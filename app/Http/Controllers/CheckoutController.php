<?php

namespace App\Http\Controllers;

use App\Data\Country\CountryStateCity;
use App\Mail\AdminBankTransferVerificationMail;
use App\Mail\AdminOrderPlacedMail;
use App\Mail\AdminOrderSuccessMail;
use App\Mail\BankTransferOrderPlacedMail;
use App\Mail\CustomarOrderPlacedMail;
use App\Mail\CustomerOrderSuccessMail;
use App\Mail\VendorOrderPlacedMail;
use App\Mail\VendorOrderSuccessMail;
use App\Models\Address;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\StateRate;
use App\Services\Checkout\CheckoutService;
use App\Services\Checkout\Data\ShippingAndBillingInformation;
use App\Services\PaymentService;
use App\Services\Shipping\EashShipProvider;
use App\Services\UPSService;
use App\Setting\Settings;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

    public function shippingAndBillingInformationPage()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You need to login first to proceed to checkout.');
        }
        return view('pages.checkout');
    }
    public function storeBillingAndShippingInformation(Request $request)
    {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'address_1' => 'required',
            'city' => 'required',
            'state' => 'required',
            'post_code' => 'required',
            'phone' => 'required',
            'delivery_option' => 'required',
            'country' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Get country details from database
            $country = Country::find($request->country);
            if (!$country) {
                throw new \Exception('Invalid country selected');
            }

            // Get state details from database
            $stateRate = StateRate::find($request->state);
            if (!$stateRate) {
                throw new \Exception('Invalid state selected');
            }

            $shippingAndBillingInformation = new ShippingAndBillingInformation(
                firstName: $request->first_name,
                lastName: $request->last_name,
                email: $request->email,
                address_line: $request->address_1,
                latitude: null,
                longitude: null,
                city: $request->city ?? '',
                state: $stateRate->state,
                state_code: $stateRate->id,
                state_name: $stateRate->state,
                post_code: $request->post_code,
                phone: $request->phone,
                country_code: $country->code,
                country_name: $country->name
            );

            $checkoutService = new CheckoutService($shippingAndBillingInformation, $request->delivery_option);
            $order = $checkoutService->createOrder();


            DB::commit();

            return redirect()->route('checkout.paymentPage', $order);
        } catch (\Throwable $e) {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
            return back()->withErrors(['checkout' => $e->getMessage()])->withInput();
        }
    }

    public function paymentPage(Order $order)
    {
        $shipping = json_decode($order->shipping, true);
        $packages = $order->products;

        // Get state rate based on state_code (which stores state_rate_id)
        $stateRate = null;
        if (isset($shipping['state_code'])) {
            $stateRate = StateRate::find($shipping['state_code']);
        }

        // Fallback to Shipping table if state rate not found
        $shippingRate = $stateRate ?? Shipping::where('country_code', $shipping['country_code'])->first();

        if (!$shippingRate) {
            $shippingRate = Shipping::where('default', 1)->first();
        }

        return view('pages.checkout-payment', [
            'order' => $order,
            'shippingRate' => $shippingRate,
            'packages' => $packages,
        ]);
    }

    public function confirmOrder(Order $order, Request $request)
    {
        $shipping = json_decode($order->shipping, true);
        // Check if country code is USA (using code from Country table)
        if ($order->delivery_option == 'pickup_point') {
            $shippingAmount = 0;
        } else {
            if (in_array($shipping['country_code'], ['US', 'USA']) && $order->subtotal >= Settings::setting('free_shipping_minimum', 75)) {
                $shippingAmount = 0;
            } else {
                $shippingAmount = $request->selected_shipping_amount;
            }
        }


        $stateRate = null;
        if (isset($shipping['state_code'])) {
            $stateRate = StateRate::find($shipping['state_code']);
        }

        // Fallback to Shipping table if state rate not found
        $shippingRate = $stateRate ?? Shipping::where('country_code', $shipping['country_code'])->first();

        if (!$shippingRate) {
            $shippingRate = Shipping::where('default', 1)->first();
        }

        if ($order->delivery_option == 'pickup_point') {
            $tax = 0;
        } else {
            $state_tax = $shippingRate->tax ?? ($shippingRate->tax ?? 0);
            $tax = ($order->subtotal * ($state_tax / 100));
        }


        // $free = SohojFacade::freeShippingInfo();


        $order->update([
            'shipping_method' => $request->selected_shipping_service,
            'shipping_total' => $shippingAmount,
            'state_tax' => $tax,
            'total' => ($order->subtotal + $shippingAmount + $tax) - $order->discount,
            'payment_method' => $request->payment_method,
            'bank_payment_status' => $request->payment_method === 'bank_transfer' ? 'pending' : null,
        ]);
        // dd($order);

        // Store order ID in session for guest access to bank transfer page
        Session::put('last_order_id', $order->id);

        $payment = new PaymentService(Order::find($order->id));
        $url = $payment->getPaymentRedirectUrl();

        // Send emails based on payment method - bank transfer emails sent after receipt upload
        if ($request->payment_method !== 'bank_transfer') {
            // Send regular order placed emails for other payment methods
            foreach ($order->childs as $childOrder) {
                if ($shipping['email']) {
                    Mail::to($shipping['email'])->send(new CustomarOrderPlacedMail($order, $childOrder));
                }
                if (optional($childOrder->shop)->email) {
                    Mail::to(optional($childOrder->shop)->email)->send(new VendorOrderPlacedMail($order, $childOrder));
                }
                if (Settings::setting('admin_email')) {
                    Mail::to(Settings::setting('admin_email'))->send(new AdminOrderPlacedMail($order, $childOrder));
                }
            }
        }

        return redirect($url);
    }



    public function store(Request $request)
    {

        $request->validate([
            // 'prevoius_address' => ['required'],
            'first_name' => ['required', 'max:40'],
            'last_name' => ['required', 'max:40'],
            'email' => ['required', 'max:40', 'email'],
            'terms' => ['required'],
            'payment_method' => 'required'
        ], [
            'prevoius_address.required' => 'You need to set a address first  by clicking "Add Address" bellow'
        ]);

        $shipping = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'country' => $request->country,
            'state' => $request->state,
            'phone' => $request->phone,
            'shipping_method' => null,
            'shipping_url' => null,
        ];


        // try {
        $order = (new CheckoutService())->createOrder();

        // Clear cart and related session data after successful order creation
        // Cart::destroy();
        // Session::forget(['discount', 'discount_code', 'coupon_id']);
    }

    protected function decreaseQuantities()
    {
        foreach (Cart::getContent() as $item) {
            // Check if item has SKU
            if (isset($item->options['sku_id']) && $item->options['sku_id']) {
                $sku = \App\Models\Sku::find($item->options['sku_id']);
                if ($sku) {
                    // Decrement SKU quantity
                    $sku->decrement('quantity', $item->qty);

                    // Also update product total sales
                    $product = Product::find($item->model->id);
                    $product->increment('total_sale', $item->qty);
                    continue;
                }
            }

            // Fallback to product quantity for non-variable products
            $product = Product::find($item->model->id);
            $product->increment('total_sale', $item->qty);
            $product->decrement('quantity', $item->qty);
        }
    }
    protected function notification($user, $shop)
    {
        Notification::create([
            'url' => env('APP_URL') . '/vendor/dashboard/orders/index',
            'title' => 'Order Created',
            'shop_id' => $shop,
        ]);
    }

    protected function productsAreNoLongerAvailable()
    {
        foreach (Cart::Content() as $item) {
            $product = Product::find($item->model->id);
            if ($product->quantity < $item->qty) {
                return true;
            }
        }
        return false;
    }
    public function userAddress(Request $request)
    {

        Address::create([
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'post_code' => $request->post_code,
            'user_id' => auth()->id(),
        ]);
        return redirect()->back()->with('success_msg', 'Address create successfull ');
    }

    public function handle(Order $order, Request $request)
    {
        $transactionId = $request->get('payment_intent');
        // Only proceed if transaction ID exists (payment successful)
        if (!$transactionId) {
            Log::error('Stripe payment failed - no transaction ID', ['order_id' => $order->id]);
            return redirect()->route('payment.cancel')->with('error', 'Payment was not successful. Please try again.');
        }
        
        $order->update([
            'status' => 1,
            'payment_status' => 1,
            'transaction_id' => $transactionId,
        ]);

        foreach ($order->childs as $childOrder) {
            $childOrder->update(['payment_status' => 1, 'transaction_id' => $transactionId, 'status' => 1]);

            try {
                Mail::to($childOrder->shop->email)->send(new VendorOrderSuccessMail($childOrder));
            } catch (\Exception $e) {
                // Log the error for vendor email
                \Log::error('Failed to send vendor order email for order: ' . $childOrder->id . '. Error: ' . $e->getMessage());
            }
        }

        try {
            Mail::to(json_decode($order->shipping, true)['email'])->send(new CustomerOrderSuccessMail($order));
        } catch (\Exception $e) {
            // Log the error for customer email
            \Log::error('Failed to send customer order email for order: ' . $order->id . '. Error: ' . $e->getMessage());
        }

        if (Settings::setting('admin_email')) {
            try {
                Mail::to(Settings::setting('admin_email'))->send(new AdminOrderSuccessMail($order));
            } catch (\Exception $e) {
                // Log the error for admin email
                \Log::error('Failed to send admin order email for order: ' . $order->id . '. Error: ' . $e->getMessage());
            }
        }
        if (Session::has('coupon_id')) {
            $coupon = Coupon::find(Session::get('coupon_id'));
            if ($coupon) {
                $coupon->increment('used');
            }
            Session::forget('discount');
            Session::forget('discount_code');
            Session::forget('coupon_id');
        }
        Cart::destroy();

        return redirect('/thankyou')->with('thank', 'Order Created successfully!');
    }

    public function handlePaypal(Order $order, Request $request)
    {
        $paypalOrderId = $request->query('token');
        $token = \App\Services\Payouts::token();

        $captureEndpoint = Settings::setting('paypal_sandbox')
            ? 'https://api.sandbox.paypal.com/v2/checkout/orders/' . $paypalOrderId . '/capture'
            : 'https://api-m.paypal.com/v2/checkout/orders/' . $paypalOrderId . '/capture';

        $captureResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type'  => 'application/json',
        ])
            ->withBody('{}', 'application/json')
            ->post($captureEndpoint);

        $paypalData = $captureResponse->json();

        $transactionId = $paypalData['purchase_units'][0]['payments']['captures'][0]['id'] ?? null;
        $captureStatus = $paypalData['status'] ?? null;
        $paymentStatus = $paypalData['purchase_units'][0]['payments']['captures'][0]['status'] ?? null;

        // Log the capture attempt
        Log::info('PayPal Capture Attempt', [
            'order_id' => $order->id,
            'transaction_id' => $transactionId,
            'capture_status' => $captureStatus,
            'payment_status' => $paymentStatus,
            'http_status' => $captureResponse->status()
        ]);

        // Only proceed if capture was successful
        if (!$transactionId || $paymentStatus !== 'COMPLETED') {
            Log::error('PayPal capture failed', [
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'payment_status' => $paymentStatus,
                'response' => $paypalData
            ]);
            return redirect()->route('payment.cancel')->with('error', 'Payment capture failed. Please contact support.');
        }

        // Step 3: Save to DB
        $order->update([
            'payment_status' => 1,
            'status' => 1,
            'transaction_id' => $transactionId,
        ]);
        foreach ($order->childs as $childOrder) {
            $childOrder->update(['payment_status' => 1, 'transaction_id' => $transactionId, 'status' => 1]);
            Mail::to($childOrder->shop->email)->send(new VendorOrderSuccessMail($childOrder));
        }

        Mail::to(json_decode($order->shipping, true)['email'])->send(new CustomerOrderSuccessMail($order));
        if (Settings::setting('admin_email')) {
            Mail::to(Settings::setting('admin_email'))->send(new AdminOrderSuccessMail($order));
        }

        // Decrease product quantities and increment total_sale
        $this->decreaseQuantities();

        Cart::destroy();
        session()->forget('discount');
        session()->forget('discount_code');
        return redirect('/thankyou')->with('thank', 'Order created and payment completed successfully!');
    }
}