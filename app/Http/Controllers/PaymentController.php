<?php

namespace App\Http\Controllers;

use App\Models\LiveClass;
use App\Models\Pricing;
use App\Models\RecordedVideo;
use App\Models\Quiz;
use App\Models\Transaction;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $paystack;

    public function __construct(PaystackService $paystack)
    {
        $this->paystack = $paystack;
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:class,video,live_class,quiz',
            'item_id' => 'required|integer',
        ]);

        $item = match ($request->item_type) {
            'live_class' => LiveClass::findOrFail($request->item_id),
            'video' => RecordedVideo::findOrFail($request->item_id),
            'quiz' => Quiz::findOrFail($request->item_id),
            default => null,
        };

        $amount = $item ? $item->price : 0;

        if ($amount <= 0) {
            return response()->json([
                'free' => true,
                'message' => 'Item is free — access granted',
            ]);
        }

        $existing = Transaction::where('user_id', auth()->id())
            ->where('item_type', $request->item_type)
            ->where('item_id', $request->item_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            $verification = $this->paystack->verifyTransaction($existing->reference);

            $isStillValid = $verification['status']
                && ($verification['data']['status'] === 'pending'
                    || $verification['data']['status'] === 'success');

            if ($isStillValid) {
                if ($verification['data']['status'] === 'success') {
                    $existing->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'paystack_response' => $verification,
                    ]);
                    return response()->json([
                        'already_completed' => true,
                        'message' => 'Payment already completed — access granted',
                    ]);
                }

                return response()->json([
                    'authorization_url' => $existing->paystack_response['data']['authorization_url'],
                    'reference' => $existing->reference,
                    'public_key' => config('services.paystack.public_key'),
                    'email' => auth()->user()->email,
                    'amount' => $amount * 100,
                ]);
            }

            $existing->update([
                'status' => 'failed',
                'failure_reason' => 'Paystack reference expired or invalid',
            ]);
        }

        return DB::transaction(function () use ($request, $amount) {
            $reference = 'TXN-' . strtoupper((string) Str::uuid());

            $transaction = Transaction::create([
                'reference' => $reference,
                'user_id' => auth()->id(),
                'amount' => $amount,
                'currency' => 'NGN',
                'status' => 'pending',
                'item_type' => $request->item_type,
                'item_id' => $request->item_id,
                'metadata' => json_encode([
                    'user_id' => auth()->id(),
                    'item_type' => $request->item_type,
                    'item_id' => $request->item_id,
                ]),
            ]);

            $paystackResponse = $this->paystack->initializeTransaction([
                'email' => auth()->user()->email,
                'amount' => $amount * 100,
                'reference' => $reference,
                'currency' => 'NGN',
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->id(),
                    'item_type' => $request->item_type,
                    'item_id' => $request->item_id,
                ],
            ]);

            if (!$paystackResponse['status']) {
                $transaction->update(['status' => 'failed', 'failure_reason' => $paystackResponse['message'] ?? 'Paystack initialization failed']);
                return response()->json(['error' => 'Payment initialization failed'], 422);
            }

            $transaction->update(['paystack_response' => $paystackResponse]);

            return response()->json([
                'authorization_url' => $paystackResponse['data']['authorization_url'],
                'reference' => $reference,
                'public_key' => config('services.paystack.public_key'),
                'email' => auth()->user()->email,
                'amount' => $amount * 100,
            ]);
        });
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;

        $transaction = Transaction::where('reference', $reference)->first();

        if (!$transaction) {
            return response('<html><body><script>window.close();</script><p>Transaction not found. You may close this tab.</p></body></html>')
                ->header('Content-Type', 'text/html');
        }

        $updated = Transaction::where('reference', $reference)
            ->where('status', 'pending')
            ->update(['paystack_response' => null]);

        if ($updated === 0) {
            return response('<html><body><script>window.close();</script><p>Payment already completed. You may close this tab.</p></body></html>')
                ->header('Content-Type', 'text/html');
        }

        $verification = $this->paystack->verifyTransaction($reference);

        if ($verification['status'] && $verification['data']['status'] === 'success') {
            Transaction::where('reference', $reference)
                ->whereNull('paystack_response')
                ->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'paystack_response' => $verification,
                ]);
        } else {
            Transaction::where('reference', $reference)
                ->whereNull('paystack_response')
                ->update([
                    'status' => 'failed',
                    'failure_reason' => $verification['data']['gateway_response'] ?? 'Payment verification failed',
                    'paystack_response' => $verification,
                ]);
        }

        $transaction->refresh();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status' => $transaction->status,
                'message' => $transaction->status === 'completed' ? 'Payment successful' : 'Payment verification failed',
            ]);
        }

        return response('<html><body><script>window.close();</script><p>Payment processed. You may close this tab.</p></body></html>')
            ->header('Content-Type', 'text/html');
    }

    public function webhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (!$this->paystack->verifyWebhookSignature($signature, $payload)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        $event = $request->event;

        if ($event === 'charge.success') {
            $reference = $request->data['reference'];

            $updated = Transaction::where('reference', $reference)
                ->where('status', 'pending')
                ->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                    'paystack_response' => $request->data,
                ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
