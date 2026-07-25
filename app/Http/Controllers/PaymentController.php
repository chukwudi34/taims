<?php

namespace App\Http\Controllers;

use App\Models\LiveClass;
use App\Models\Pricing;
use App\Models\RecordedVideo;
use App\Models\Quiz;
use App\Models\Transaction;
use App\Services\PaystackService;
use Illuminate\Http\Request;

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

        $reference = 'TXN-' . strtoupper(uniqid());

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
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;

        $transaction = Transaction::where('reference', $reference)->first();

        if (!$transaction) {
            return response('<html><body><script>window.close();</script><p>Transaction not found. You may close this tab.</p></body></html>')
                ->header('Content-Type', 'text/html');
        }

        if ($transaction->status === 'completed') {
            return response('<html><body><script>window.close();</script><p>Payment already completed. You may close this tab.</p></body></html>')
                ->header('Content-Type', 'text/html');
        }

        $verification = $this->paystack->verifyTransaction($reference);

        $transaction->update(['paystack_response' => $verification]);

        if ($verification['status'] && $verification['data']['status'] === 'success') {
            $transaction->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        } else {
            $transaction->update([
                'status' => 'failed',
                'failure_reason' => $verification['data']['gateway_response'] ?? 'Payment verification failed',
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

            $transaction = Transaction::where('reference', $reference)->first();

            if (!$transaction || $transaction->status === 'completed') {
                return response()->json(['status' => 'ok']);
            }

            $transaction->update([
                'status' => 'completed',
                'paid_at' => now(),
                'paystack_response' => $request->data,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
}
