<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verified - Order Confirmed</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f5f5f5; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background-color: #ffffff; max-width: 600px;">
                    <!-- Header -->
                    <tr>
                        <td
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 40px 20px; text-align: center;">
                            <div style="font-size: 60px; margin-bottom: 10px;">✅</div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px;">Payment Verified!</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">Your Order is Confirmed</p>
                        </td>
                    </tr>


                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 20px;">
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Dear {{ json_decode($order->shipping)->first_name ?? 'Customer' }},
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Great news! We have successfully verified your bank transfer payment. Your order is now
                                confirmed and being processed.
                            </p>

                            <!-- Order Confirmed Box -->
                            <table width="100%" cellpadding="30" cellspacing="0"
                                style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border: 2px solid #10b981; margin: 30px 0;">
                                <tr>
                                    <td style="text-align: center;">
                                        <h2 style="margin: 0 0 15px 0; color: #047857; font-size: 24px;">🎉 Order
                                            Confirmed!</h2>
                                        <p style="margin: 5px 0; color: #065f46; font-size: 18px;">
                                            <strong>Order ID:</strong> #{{ $order->id }}<br>
                                            <strong>Amount Paid:</strong> <span
                                                style="font-size: 24px; font-weight: bold;">${{ number_format($order->total, 2) }}</span><br>
                                            <strong>Payment Status:</strong> <span
                                                style="color: #10b981; font-weight: bold;">✓ VERIFIED</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- What's Next -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #f8f9fa; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #333333; font-size: 20px;">📦 What's Next?
                                        </h2>
                                        <ul style="margin: 10px 0; padding-left: 20px; color: #555; line-height: 1.8;">
                                            <li>Your order is now being prepared for shipment</li>
                                            <li>You will receive a shipping confirmation email with tracking details
                                            </li>
                                            <li>Estimated delivery: 3-5 business days</li>
                                            <li>Track your order status anytime from your account</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Summary -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #dbeafe; border-left: 4px solid #3b82f6; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #3b82f6; font-size: 20px;">📋 Order
                                            Summary</h2>
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="border-collapse: collapse;">
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Subtotal:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    ${{ number_format($order->subtotal, 2) }}</td>
                                            </tr>
                                            @if ($order->shipping_total)
                                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 10px 0; color: #666;">Shipping:</td>
                                                    <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                        ${{ number_format($order->shipping_total, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($order->state_tax)
                                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 10px 0; color: #666;">Tax:</td>
                                                    <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                        ${{ number_format($order->state_tax, 2) }}</td>
                                                </tr>
                                            @endif
                                            @if ($order->discount)
                                                <tr style="border-bottom: 1px solid #e5e7eb;">
                                                    <td style="padding: 10px 0; color: #666;">Discount:</td>
                                                    <td
                                                        style="padding: 10px 0; text-align: right; font-weight: bold; color: #10b981;">
                                                        -${{ number_format($order->discount, 2) }}</td>
                                                </tr>
                                            @endif
                                            <tr style="background-color: #f3f4f6;">
                                                <td
                                                    style="padding: 15px 10px; color: #111827; font-size: 18px; font-weight: bold;">
                                                    Total:</td>
                                                <td
                                                    style="padding: 15px 10px; text-align: right; color: #10b981; font-size: 20px; font-weight: bold;">
                                                    ${{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 30px 0 20px 0;">
                                Thank you for shopping with us! If you have any questions about your order, feel free to
                                contact our customer support.
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 30px 0 20px 0;">
                                <strong>Note</strong> {{ $order->bank_payment_notes ?? 'Thank you for your payment.' }}
                            </p>

                            <!-- Buttons -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ env('APP_URL') }}"
                                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); 
                                                  color: #ffffff; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  display: inline-block; 
                                                  font-weight: bold;
                                                  margin: 5px;">
                                            Track Your Order
                                        </a>
                                        <a href="{{ env('APP_URL') }}"
                                            style="background: #ffffff; 
                                                  color: #10b981; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  display: inline-block; 
                                                  font-weight: bold;
                                                  border: 2px solid #10b981;
                                                  margin: 5px;">
                                            Continue Shopping
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 20px 0 0 0;">
                                Best regards,<br>
                                <strong>{{ config('app.name') }} Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                Need help? Contact us at
                                {{ \App\Setting\Settings::setting('admin_email') ?? 'support@example.com' }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
