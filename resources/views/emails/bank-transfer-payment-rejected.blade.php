<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Rejected - Order #{{ $order->id }}</title>
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
                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); padding: 40px 20px; text-align: center;">
                            <div style="font-size: 60px; margin-bottom: 10px;">❌</div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px;">Payment Rejected</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">Order #{{ $order->id }}
                            </p>
                        </td>
                    </tr>


                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 20px;">
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Dear {{ json_decode($order->shipping)->first_name ?? 'Customer' }},
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                We regret to inform you that we were unable to verify your bank transfer payment for
                                Order #{{ $order->id }}.
                                Your order has been cancelled.
                            </p>

                            <!-- Rejection Box -->
                            <table width="100%" cellpadding="30" cellspacing="0"
                                style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); border: 2px solid #ef4444; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #991b1b; font-size: 24px;">⚠️ Payment
                                            Rejected</h2>
                                        <p style="margin: 5px 0; color: #7f1d1d; font-size: 16px; line-height: 1.6;">
                                            <strong>Order ID:</strong> #{{ $order->id }}<br>
                                            <strong>Amount:</strong> ${{ number_format($order->total, 2) }}<br>
                                            <strong>Status:</strong> <span
                                                style="color: #ef4444; font-weight: bold;">CANCELLED</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Rejection Reason -->
                            @if ($order->bank_payment_notes)
                                <table width="100%" cellpadding="20" cellspacing="0"
                                    style="background-color: #fef3c7; border-left: 4px solid #f59e0b; margin: 30px 0;">
                                    <tr>
                                        <td>
                                            <h2 style="margin: 0 0 15px 0; color: #92400e; font-size: 20px;">📝 Reason
                                                for Rejection</h2>
                                            <p style="margin: 0; color: #78350f; line-height: 1.6; font-size: 15px;">
                                                {{ $order->bank_payment_notes }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- What to Do Next -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #dbeafe; border-left: 4px solid #3b82f6; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #1e40af; font-size: 20px;">💡 What to Do
                                            Next?</h2>
                                        <ul
                                            style="margin: 10px 0; padding-left: 20px; color: #1e3a8a; line-height: 1.8;">
                                            <li>Review the rejection reason above</li>
                                            <li>Verify your bank transfer details and receipt</li>
                                            <li>Place a new order if you wish to purchase again</li>
                                            <li>Contact our support team if you have questions</li>
                                            <li>Choose a different payment method for faster processing</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Summary -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #f9fafb; border: 1px solid #e5e7eb; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #333333; font-size: 20px;">📋 Order
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
                                                    style="padding: 15px 10px; text-align: right; color: #ef4444; font-size: 20px; font-weight: bold;">
                                                    ${{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 30px 0 20px 0;">
                                We apologize for any inconvenience. If you believe this was an error or have questions,
                                please don't hesitate to contact our customer support team.
                            </p>

                            <!-- Buttons -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ env('APP_URL') }}"
                                            style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); 
                                                  color: #ffffff; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  display: inline-block; 
                                                  font-weight: bold;
                                                  margin: 5px;">
                                            Shop Again
                                        </a>
                                        <a href="mailto:{{ config('mail.from.address') }}"
                                            style="background: #ffffff; 
                                                  color: #3b82f6; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  border: 2px solid #3b82f6;
                                                  display: inline-block; 
                                                  font-weight: bold;
                                                  margin: 5px;">
                                            Contact Support
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f9fafb; padding: 30px 20px; text-align: center; color: #6b7280;">
                            <p style="margin: 0 0 10px 0; font-size: 14px;">
                                <strong>Need Help?</strong>
                            </p>
                            <p style="margin: 0 0 10px 0; font-size: 14px;">
                                Contact us at: <a href="mailto:{{ config('mail.from.address') }}"
                                    style="color: #3b82f6; text-decoration: none;">{{ config('mail.from.address') }}</a>
                            </p>
                            <p style="margin: 20px 0 0 0; font-size: 12px; color: #9ca3af;">
                                This email was sent regarding your order #{{ $order->id }}.<br>
                                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
