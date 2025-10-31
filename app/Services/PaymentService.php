<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Support\Facades\Http;
use App\Setting\Settings;
use Exception;


class PaymentService
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getPaymentRedirectUrl()
    {
        switch (strtolower($this->order->payment_method)) {
            case 'stripe':
                return $this->createStripeCheckoutLink();
            case 'paypal':
                return $this->createPayPalCheckoutLink();
            case 'cash':
                return route('thankyou');
            default:
                throw new Exception('Invalid payment method.');
        }
    }

    public function createStripeCheckoutLink()
    {

        Stripe::setApiKey(Settings::setting('stripe_secret'));

        $lineItems = [];
        $totalAmount = 0;

        foreach ($this->order->products as $product) {
            // if (empty($shopOrder->p) || empty($shopOrder->quantity)) {
            //     continue;
            // }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->name,   
                    ],
                    'unit_amount' => intval(($product->pivot->price) * 100), // Stripe expects amount in cents
                ],
                'quantity' => $product->pivot->quantity,
            ];
        }
        $totalAmount = $this->order->total;


        if (empty($lineItems)) {
            throw new \Exception('No products found for this order. Cannot create Stripe Checkout Session.');
        }

        // Calculate tax amount (you can customize this logic)
        $taxRate = $this->getTaxRate(); // Get tax rate from your system

        $taxAmount = $taxRate * 100;
        // Add tax as a separate line item
        if ($taxRate > 0) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Tax',
                        'description' => 'Sales tax',
                    ],
                    'unit_amount' => intval($taxAmount),
                ],
                'quantity' => 1,
            ];
        }

        if ($this->order->shipping_total) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Shipping',
                        'description' => 'Shipping cost',
                    ],
                    'unit_amount' => intval($this->order->shipping_total * 100),
                ],
                'quantity' => 1,
            ];
        }


        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => $this->order->shipping['email'] ?? null,
            'success_url' => route('payment.handle', $this->order) . '?payment_intent={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
            'metadata' => [
                'order_id' => $this->order->id,
                'tax_amount' => $taxAmount,

            ],
            // Alternative: Use Stripe's automatic tax calculation
            // 'automatic_tax' => [
            //     'enabled' => true,
            // ],
            // 'tax_id_collection' => [
            //     'enabled' => true,
            // ],
        ]);

        return $session->url;
    }

    /**
     * Get tax rate based on location or other criteria
     */
    private function getTaxRate()
    {
        // Method 1: Fixed tax rate
        return \Sohoj::tax(); // 8% tax rate

        // Method 2: Get from order/shipping address
        // if ($this->order->shipping) {
        //     $shipping = json_decode($this->order->shipping);
        //     return $this->getTaxRateByLocation($shipping->state ?? 'CA');
        // }

        // Method 3: Get from environment variable
        // return env('DEFAULT_TAX_RATE', 0.08);
    }

    /**
     * Get tax rate by location (example)
     */
    private function getTaxRateByLocation($state)
    {
        $taxRates = [
            'CA' => 0.0825, // California
            'NY' => 0.08,   // New York
            'TX' => 0.0625, // Texas
            'FL' => 0.06,   // Florida
            // Add more states as needed
        ];

        return $taxRates[$state] ?? 0.08; // Default 8%
    }

    public function createPayPalCheckoutLink()
    {

        $endpoint = Settings::setting('paypal_sandbox') === '0'
            ? 'https://api-m.paypal.com/v2/checkout/orders'
            : 'https://api.sandbox.paypal.com/v2/checkout/orders';
        $token = \App\Services\Payouts::token();
        $body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => $this->order->total,
                ],
                'description' => 'Order #' . $this->order->id,
            ]],
            'application_context' => [
                'return_url' => route('payment.handle.paypal', $this->order),
                'cancel_url' =>  route('payment.cancel'),
            ],
        ];
        $response = Http::withToken($token)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post($endpoint, $body);
        $data = $response->json();
        if (isset($data['links'])) {
            foreach ($data['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return $link['href'];
                }
            }
        }
        throw new Exception('Unable to create PayPal payment link.');
    }
}
