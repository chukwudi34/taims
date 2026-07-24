<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackService
{
    protected $secretKey;
    protected $paymentUrl;

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->paymentUrl = config('services.paystack.payment_url', 'https://api.paystack.co');
    }

    public function initializeTransaction(array $params): array
    {
        $response = Http::withToken($this->secretKey)
            ->post($this->paymentUrl . '/transaction/initialize', $params);

        return $response->json();
    }

    public function verifyTransaction(string $reference): array
    {
        $response = Http::withToken($this->secretKey)
            ->get($this->paymentUrl . '/transaction/verify/' . $reference);

        return $response->json();
    }

    public function verifyWebhookSignature(string $signature, string $payload): bool
    {
        $hash = hash_hmac('sha512', $payload, $this->secretKey);
        return hash_equals($hash, $signature);
    }
}
