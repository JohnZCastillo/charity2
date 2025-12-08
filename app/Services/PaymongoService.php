<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaymongoService
{
    protected $secretKey;

    public function __construct()
    {
        $this->secretKey = env('PAYMONGO_SECRET_KEY');
    }

    public function createPaymentIntent($amount, $paymentMethod, $currency = 'PHP')
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post('https://api.paymongo.com/v1/payment_intents', [
                'data' => [
                    'attributes' => [
                        'amount' => $amount * 100, // PayMongo requires CENTS
                        'payment_method_allowed' => [$paymentMethod],
                        'currency' => strtolower($currency),
                    ]
                ]
            ]);

        return $response->json();
    }

    public function attachPaymentMethod($intentId, $paymentMethodId)
    {
        $response = Http::withBasicAuth($this->secretKey, '')
            ->post("https://api.paymongo.com/v1/payment_intents/{$intentId}/attach", [
                'data' => [
                    'attributes' => [
                        'payment_method' => $paymentMethodId
                    ]
                ]
            ]);

        return $response->json();
    }
}
