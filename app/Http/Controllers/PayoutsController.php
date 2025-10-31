<?php

namespace App\Http\Controllers;

use App\Facade\Sohoj;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Refund;
use App\Models\User;
use App\Services\Payouts;
use Exception;
use Illuminate\Support\Facades\Http;
use Shop;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PayoutsController extends Controller
{
    public function payouts(Order $order)
    {

        if (!isset($order->shop->user->verification->paypal_email)) {
            return back()->with([
                'message'    => "Shop does not have paypal email",
                'alert-type' => 'success',
            ]);
        }
        $total_format = $order->vendor_total + $order->shipping_total;
        $token = Payouts::token();

        $body =  [
            "sender_batch_header" => [
                "sender_batch_id" => "Payout_$order->id",
                "recipient_type" => "EMAIL",
                "email_subject" => "You have a new order: $order->id!",
                "email_message" => "You have received a payment. Thank you for using our platform."
            ],
            "items" => [
                [
                    "recipient_type" => "EMAIL",
                    "amount" => [
                        "value" => "$total_format",
                        "currency" => "USD"
                    ],
                    "sender_item_id" => "$order->id",
                    "recipient_wallet" => "PAYPAL",
                    "receiver" => 'reovil@test.com',
                ]
            ]
        ];
        try {
            $response = Http::withToken($token)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->withBody(json_encode($body), 'application/json')
                ->post('https://api.sandbox.paypal.com/v1/payments/payouts');


            if (json_decode($response->status()) == 200 || json_decode($response->status()) == 201) {
                $order->update(['payouts_status' => 1]);
                $this->notification($order->shop->id);
            } else {
                return back()->with([
                    'message'    => $response->object()->message,
                    'alert-type' => 'error',
                ]);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return back()->with([
            'message'    => "Payouts success",
            'alert-type' => 'success',
        ]);
    }
    protected function notification($shop)
    {
        Notification::create([
            'url' => env('APP_URL') . '/vendor/dashboard/orders/index',
            'title' => 'Your money has been send please check',
            'shop_id' => $shop,
        ]);
    }
    public function cancel_order()
    {
        $canceledOrders = Order::where('status', 3)->whereNull('refund_amount')->latest()->get();
        return view('auth.admin.order.canceled', compact('canceledOrders'));
    }
    public function refund()
    {
        $refundedOrders = Refund::latest()->get();
        return view('auth.admin.order.refund', compact('refundedOrders'));
    }
    public function refund_store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'refund_amount' => 'required|numeric',
        ]);

        $user = User::find($request->user_id);
        $order = Order::find($request->order_id);



        $user->refund($order->transaction_id);


        $order->update([
            'refund_amount' => $validatedData['refund_amount'],
        ]);


        Refund::create([
            'user_id' => $validatedData['user_id'],
            'order_id' => $validatedData['order_id'],
            'refund_amount' => $validatedData['refund_amount'],
        ]);



        return redirect()->route('refund.order')->with('success', 'Refund successfully processed.');
    }
}
