<?php

namespace App\Http\Controllers;

use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $paystackService;

    public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }

    public function initiatePayment(Request $request)
    {
        // Store registration data in session
        Session::put('registration_data', $request->all());

        // Generate a unique reference
        $reference = 'FFDREG_' . Str::random(10);
        Session::put('payment_reference', $reference);

        // Initialize transaction with Paystack
        $data = [
            'email' => $request->email,
            'amount' => 100000, // Amount in kobo (1,000 Naira)
            'reference' => $reference,
            'callback_url' => route('payment.callback'),
            'metadata' => [
                'registration_type' => 'player',
                'name' => $request->name,
            ]
        ];

        $response = $this->paystackService->initializeTransaction($data);

        if (!$response['status']) {
            return back()->with('error', $response['message']);
        }

        // Redirect to Paystack payment page
        return redirect($response['data']['authorization_url']);
    }

    public function handleCallback(Request $request)
    {
        $reference = $request->reference ?? Session::get('payment_reference');
        
        if (!$reference) {
            return redirect()->route('register')->with('error', 'Payment reference not found.');
        }

        $response = $this->paystackService->verifyTransaction($reference);

        if (!$response['status'] || $response['data']['status'] !== 'success') {
            return redirect()->route('register')->with('error', 'Payment was not successful. Please try again.');
        }

        // Payment successful, proceed with registration
        return redirect()->route('register.complete');
    }
} 