<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected $baseUrl;
    protected $secretKey;
    protected $publicKey;

    public function __construct()
    {
        $this->baseUrl = config('services.paystack.base_url');
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
    }

    public function initializeTransaction(array $data)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post($this->baseUrl . '/transaction/initialize', $data);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Paystack transaction initialization failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Payment initialization failed. Please try again.'
            ];
        }
    }

    public function verifyTransaction($reference)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->get($this->baseUrl . '/transaction/verify/' . $reference);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Paystack transaction verification failed: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Payment verification failed. Please contact support.'
            ];
        }
    }
} 