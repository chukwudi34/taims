<?php

namespace App\Http\Controllers;

use App\Models\Pricing;
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

        $pricing = Pricing::where('item_type', $request->item_type)
            ->where('item_id', $request->item_id)
            ->where('is_active', true)
            ->firstOrFail();

        $reference = 'TXN-' . strtoupper(uniqid());

        $transaction = Transaction::create([
            'reference' => $reference,
            'user_id' => auth()->id(),
            'amount' => $pricing->amount,
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
            'amount' => $pricing->amount * 100,
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
        ]);
    }

    public function callback(Request $request)
    {
        $reference = $request->reference;

        $transaction = Transaction::where('reference', $reference)->firstOrFail();

        if ($transaction->status === 'completed') {
            return redirect('/purchases')->with('success', 'Payment already completed');
        }

        $verification = $this->paystack->verifyTransaction($reference);

        $transaction->update(['paystack_response' => $verification]);

        if ($verification['status'] && $verification['data']['status'] === 'success') {
            $transaction->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);

            return redirect('/purchases')->with('success', 'Payment successful! Access granted.');
        }

        $transaction->update([
            'status' => 'failed',
            'failure_reason' => $verification['data']['gateway_response'] ?? 'Payment verification failed',
        ]);

        return redirect('/purchases')->with('error', 'Payment verification failed. Please try again.');
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
