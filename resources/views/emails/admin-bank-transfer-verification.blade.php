<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Bank Transfer Payment Awaiting Verification</title>
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
                            <div style="font-size: 60px; margin-bottom: 10px;">⚠️</div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Action Required</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">New Bank Transfer Payment to
                                Verify</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 20px;">
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Hello Admin,
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                A new order has been placed with <strong>Bank Transfer</strong> payment method and
                                requires your verification.
                            </p>

                            <!-- Alert Box -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #fee2e2; border-left: 4px solid #ef4444; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #ef4444; font-size: 20px;">
                                            <strong>⏰ Pending Verification Required</strong>
                                        </h2>
                                        <p style="margin: 0; color: #991b1b; line-height: 1.6;">
                                            The customer has uploaded a payment receipt. Please review and verify the
                                            payment to complete the order.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Order Details -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #f8f9fa; border-radius: 8px; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #111827; font-size: 20px;">📦 Order
                                            Information</h2>
                                        <table width="100%" cellpadding="0" cellspacing="0"
                                            style="border-collapse: collapse;">
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Order ID:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    #{{ $order->id }}</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Customer:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    @php
                                                        $shipping = json_decode($order->shipping);
                                                    @endphp
                                                    {{ $shipping->first_name ?? '' }} {{ $shipping->last_name ?? '' }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Email:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    {{ $shipping->email ?? 'N/A' }}</td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Order Total:</td>
                                                <td
                                                    style="padding: 10px 0; text-align: right; font-weight: bold; color: #10b981; font-size: 18px;">
                                                    ${{ number_format($order->total, 2) }}
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                                <td style="padding: 10px 0; color: #666;">Payment Method:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    Direct Bank Transfer</td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; color: #666;">Order Date:</td>
                                                <td style="padding: 10px 0; text-align: right; font-weight: bold;">
                                                    {{ $order->created_at->format('F j, Y g:i A') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Receipt Info -->
                            @if ($order->bank_transfer_receipt)
                                <table width="100%" cellpadding="20" cellspacing="0"
                                    style="background-color: #dbeafe; border-left: 4px solid #3b82f6; margin: 30px 0;">
                                    <tr>
                                        <td>
                                            <h2 style="margin: 0 0 15px 0; color: #1e40af; font-size: 20px;">📄 Payment
                                                Receipt</h2>
                                            <p style="margin: 0; color: #1e3a8a; line-height: 1.6;">
                                                <strong>File:</strong> {{ basename($order->bank_transfer_receipt) }}<br>
                                                <strong>Uploaded:</strong> {{ $order->created_at->diffForHumans() }}
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            @endif

                            <!-- Action Steps -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #f0fdf4; border-left: 4px solid #10b981; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #047857; font-size: 20px;">✅ Next Steps
                                        </h2>
                                        <ol
                                            style="margin: 10px 0; padding-left: 20px; color: #065f46; line-height: 1.8;">
                                            <li>Log in to the admin panel</li>
                                            <li>Navigate to Orders → Orders List</li>
                                            <li>Open Order #{{ $order->id }}</li>
                                            <li>Click "View Receipt" to review the payment proof</li>
                                            <li>Click "Verify Payment" to approve or "Reject Payment" to decline</li>
                                            <li>Customer will be automatically notified of your decision</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 30px 0 20px 0;">
                                Please verify this payment as soon as possible to ensure smooth order processing.
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ env('APP_URL') }}/admin/resources/orders/{{ $order->id }}"
                                            style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); 
                                                  color: #ffffff; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  display: inline-block; 
                                                  font-weight: bold;
                                                  box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                            View Order & Verify Payment
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 20px 0 0 0;">
                                Best regards,<br>
                                <strong>{{ config('app.name') }} System</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="background-color: #f8f9fa; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="margin: 0; font-size: 14px; color: #6b7280;">
                                This is an automated notification. Please log in to the admin panel to take action.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
