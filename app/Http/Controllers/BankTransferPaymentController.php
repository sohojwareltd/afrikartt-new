<?php

namespace App\Http\Controllers;

use App\Mail\AdminBankTransferVerificationMail;
use App\Mail\BankTransferOrderPlacedMail;
use App\Models\BankTransferSetting;
use App\Models\Order;
use App\Setting\Settings;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BankTransferPaymentController extends Controller
{
    /**
     * Display the bank transfer payment page
     */
    public function showPaymentPage($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Security check - ensure order belongs to current user or is guest order
        $shipping = json_decode($order->shipping);

        if (Auth::check()) {
            // Authenticated user - check ownership
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to this order.');
            }
        } else {
            // Guest order - check session
            $sessionOrderId = session('last_order_id');
            if ($sessionOrderId != $order->id) {
                abort(403, 'Unauthorized access to this order.');
            }
        }

        // Check if payment method is bank transfer
        if ($order->payment_method !== 'bank_transfer') {
            return redirect()->route('thankyou')->with('error', 'This order does not use bank transfer payment.');
        }

        // Check if already uploaded
        if ($order->bank_transfer_receipt) {
            return view('pages.bank-transfer-submitted', compact('order'));
        }

        // Get bank transfer settings
        $settings = BankTransferSetting::settings();

        if (!$settings || !$settings->enabled) {
            return redirect()->route('thankyou')->with('error', 'Bank transfer payment is currently unavailable.');
        }

        return view('pages.bank-transfer-payment', compact('order', 'settings'));
    }

    /**
     * Handle receipt upload and payment submission
     */
    public function submitPayment(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $settings = BankTransferSetting::settings();

        // Security check - ensure order belongs to current user
        if (Auth::check()) {
            if ($order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to this order.');
            }
        } else {
            $sessionOrderId = session('last_order_id');
            if ($sessionOrderId != $order->id) {
                abort(403, 'Unauthorized access to this order.');
            }
        }

        // Check if already uploaded
        if ($order->bank_transfer_receipt) {
            return redirect()->route('payment.bank-transfer', ['order' => $order->id])
                ->with('info', 'Payment receipt has already been submitted for this order.');
        }

        // Validate receipt upload
        $maxFileSize = $settings ? $settings->max_file_size : 5120;

        $request->validate([
            'bank_receipt' => [
                'required',
                'file',
                'mimes:jpeg,jpg,png,pdf',
                'max:' . $maxFileSize
            ]
        ], [
            'bank_receipt.required' => 'Please upload your payment receipt.',
            'bank_receipt.mimes' => 'Receipt must be a JPG, PNG, or PDF file.',
            'bank_receipt.max' => 'Receipt file size must not exceed ' . ($maxFileSize / 1024) . 'MB.'
        ]);

        // Store the receipt
        $file = $request->file('bank_receipt');
        if (!$file->isValid()) {
            return redirect()->back()->withErrors(['bank_receipt' => 'Failed to upload the receipt. Please try again.']);
        }

        // Store with custom filename
        $path = $file->store('bank_transfer_receipts', 'public');

        // Update order
        $order->update([
            'bank_transfer_receipt' => $path,
            'bank_payment_status' => 'pending',
        ]);

        // Send emails
        $shipping = json_decode($order->shipping);

        // Send customer confirmation email
        if ($shipping && isset($shipping->email)) {
            try {
                Mail::to($shipping->email)->send(new BankTransferOrderPlacedMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send bank transfer customer email: ' . $e->getMessage());
            }
        }

        // Send admin notification email
        if (Settings::setting('admin_email')) {
            try {
                Mail::to(Settings::setting('admin_email'))->send(new AdminBankTransferVerificationMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send bank transfer admin email: ' . $e->getMessage());
            }
        }

        // IMPORTANT: Clear the cart after successful submission
        Cart::destroy();

        // Clear discount and coupon session data
        Session::forget(['discount', 'discount_code', 'coupon_id']);

        return redirect()->route('payment.bank-transfer', ['order' => $order->id])
            ->with('success', 'Your payment receipt has been submitted successfully! We will verify it within 12-24 hours.');
    }

    /**
     * Display success page after payment submission
     */
    public function successPage()
    {
        return view('pages.bank-transfer-success');
    }

    /**
     * Download receipt (for customer or admin)
     */
    public function downloadReceipt($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Security check
        if (Auth::check()) {
            // Allow if user owns order or is admin
            $isOwner = $order->user_id === Auth::id();
            $isAdmin = Auth::user()->hasRole('admin'); // Adjust based on your role system

            if (!$isOwner && !$isAdmin) {
                abort(403, 'Unauthorized access.');
            }
        } else {
            $sessionOrderId = session('last_order_id');
            if ($sessionOrderId != $order->id) {
                abort(403, 'Unauthorized access.');
            }
        }

        if (!$order->bank_transfer_receipt) {
            abort(404, 'Receipt not found.');
        }

        return Storage::disk('public')->download($order->bank_transfer_receipt);
    }
}