<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Received - Awaiting Payment Verification</title>
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
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 20px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 32px;">Order Received!</h1>
                            <p style="color: #ffffff; margin: 10px 0 0 0; font-size: 16px;">Awaiting Payment
                                Verification</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 20px;">
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Dear {{ json_decode($order->shipping)->first_name ?? 'Customer' }},
                            </p>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 0 0 20px 0;">
                                Thank you for your order! We have received your order and payment receipt.
                            </p>

                            <!-- Order Details -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #f8f9fa; border-left: 4px solid #667eea; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #667eea; font-size: 20px;">📋 Order
                                            Details</h2>
                                        <p style="margin: 5px 0; color: #555; line-height: 1.8;">
                                            <strong>Order ID:</strong> #{{ $order->id }}<br>
                                            <strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}<br>
                                            <strong>Payment Method:</strong> Direct Bank Transfer (US)<br>
                                            <strong>Status:</strong> <span
                                                style="color: #f59e0b; font-weight: bold;">Pending Payment
                                                Verification</span>
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- What Happens Next -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #fef3c7; border-left: 4px solid #f59e0b; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #f59e0b; font-size: 20px;">⏳ What Happens
                                            Next?</h2>
                                        <ol style="margin: 10px 0; padding-left: 20px; color: #555; line-height: 1.8;">
                                            <li>Our team will verify your bank transfer within <strong>12-24
                                                    hours</strong></li>
                                            <li>Once verified, your order will be marked as <strong>Paid</strong></li>
                                            <li>We will send you a confirmation email immediately</li>
                                            <li>Your order will be processed and shipped right away</li>
                                        </ol>
                                    </td>
                                </tr>
                            </table>

                            <!-- Important Note -->
                            <table width="100%" cellpadding="20" cellspacing="0"
                                style="background-color: #dbeafe; border-left: 4px solid #3b82f6; margin: 30px 0;">
                                <tr>
                                    <td>
                                        <h2 style="margin: 0 0 15px 0; color: #3b82f6; font-size: 20px;">💡 Important
                                            Note</h2>
                                        <p style="margin: 0; color: #555; line-height: 1.6;">
                                            If you haven't completed the bank transfer yet, please do so as soon as
                                            possible.
                                            Your order will remain on hold until payment verification is complete.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin: 30px 0 20px 0;">
                                If you have any questions or concerns, please don't hesitate to contact our support
                                team.
                            </p>

                            <!-- Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin: 40px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ env('APP_URL') }}"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                                  color: #ffffff; 
                                                  text-decoration: none; 
                                                  padding: 15px 40px; 
                                                  border-radius: 8px; 
                                                  display: inline-block; 
                                                  font-weight: bold;">
                                            View Order Status
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
                                This is an automated email. Please do not reply directly to this message.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
