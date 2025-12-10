<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Updated</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f7fa;
            padding: 20px;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: #f68b1e;
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .email-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-body {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 20px;
        }

        .message {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .status-update-card {
            background: linear-gradient(135deg, #f6f8fb 0%, #e9ecef 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            /* border-left: 4px solid #667eea; */
        }

        .order-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px dashed #cbd5e0;
        }

        .order-label {
            font-size: 13px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .order-value {
            font-size: 18px;
            color: #2d3748;
            font-weight: 700;
        }

        .status-flow {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .status-box {
            flex: 1;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-old {
            background-color: #fed7d7;
            color: #c53030;
        }

        .status-arrow {
            font-size: 24px;
            color: #667eea;
            font-weight: bold;
        }

        .status-new {
            background-color: #c6f6d5;
            color: #22543d;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.03);
            }
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }

        .status-on-its-way {
            background-color: #dbeafe;
            color: #1e3a8a;
        }

        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .status-delivered {
            background-color: #dcfce7;
            color: #14532d;
        }

        .status-message {
            margin-top: 20px;
            padding: 15px;
            background-color: #edf2f7;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .status-message-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .status-message-text {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.6;
        }

        .order-details {
            background-color: #f7fafc;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-size: 14px;
            color: #718096;
            font-weight: 500;
        }

        .detail-value {
            font-size: 14px;
            color: #2d3748;
            font-weight: 600;
        }

        .cta-button {
            display: inline-block;
            background: #f68b1e;
            color: #ffffff;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
            transition: transform 0.2s;
            /* box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3); */
        }

        .cta-button:hover {
            transform: translateY(-2px);
            /* box-shadow: 0 6px 10px rgba(102, 126, 234, 0.4); */
        }

        .button-container {
            text-align: center;
            margin: 30px 0;
        }

        .email-footer {
            background-color: #f7fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }

        .footer-text {
            font-size: 13px;
            color: #718096;
            margin-bottom: 10px;
        }

        .footer-links {
            margin-top: 15px;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
            margin: 0 10px;
            font-size: 13px;
            font-weight: 500;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #cbd5e0, transparent);
            margin: 25px 0;
        }

        @media only screen and (max-width: 600px) {
            .email-body {
                padding: 25px 20px;
            }

            .status-flow {
                flex-direction: column;
            }

            .status-arrow {
                transform: rotate(90deg);
                margin: 10px 0;
            }

            .status-box {
                width: 100%;
            }

            .order-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>📦 Order Status Updated</h1>
            <p>Your order is on the move!</p>
        </div>

        <!-- Body -->
        <div class="email-body">
            <div class="greeting">
                Hello {{ $customerName }}! 👋
            </div>

            <div class="message">
                Great news! Your order status has been updated. We're excited to keep you informed about your purchase
                journey.
            </div>

            <!-- Status Update Card -->
            <div class="status-update-card">
                <div class="order-info">
                    <div>
                        <div class="order-label">Order ID</div>
                        <div class="order-value">#{{ $order->id }}</div>
                    </div>
                    <div style="text-align: right;">
                        <div class="order-label">Order Date</div>
                        <div class="order-value">{{ $order->created_at->format('M d, Y') }}</div>
                    </div>
                </div>

                <div class="status-flow">
                    <div class="status-box status-old">
                        <div style="font-size: 11px; margin-bottom: 5px; opacity: 0.8;">Previous Status</div>
                        @php
                            $statusNames = [
                                0 => 'Pending',
                                1 => 'Paid',
                                2 => 'On Its Way',
                                3 => 'Cancelled',
                                4 => 'Delivered',
                            ];
                        @endphp
                        {{ $statusNames[$oldStatus] }}
                    </div>
                    <div class="status-arrow">→</div>
                    <div class="status-box status-new">
                        <div style="font-size: 11px; margin-bottom: 5px; opacity: 0.8;">Current Status</div>
                        {{ $statusNames[$newStatus] }}
                    </div>
                </div>

                <div class="status-message">
                    <div class="status-message-title">📋 What This Means:</div>
                    <div class="status-message-text">
                        @if ($newStatus == 0)
                            Your order is currently pending. We're processing your request and will update you soon!
                        @elseif($newStatus == 1)
                            Payment confirmed! Your order is now being prepared for shipment. Thank you for your
                            purchase!
                        @elseif($newStatus == 2)
                            🚚 Your order is on its way! It's currently in transit and will reach you soon. Track your
                            package for real-time updates.
                        @elseif($newStatus == 3)
                            Your order has been cancelled. If you have any questions, please contact our support team.
                            We're here to help!
                        @elseif($newStatus == 4)
                            🎉 Your order has been delivered! We hope you love your purchase. Thank you for shopping
                            with us!
                        @endif
                    </div>
                </div>
            </div>

            @if ($statusNote)
                <!-- Admin Note -->
                <div class="order-details"
                    style="background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%); border-left: 4px solid #f59e0b;">
                    <div style="margin-bottom: 10px;">
                        <strong style="color: #92400e; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 18px;">💬</span> Message from Our Team
                        </strong>
                    </div>
                    <div style="color: #78350f; font-size: 14px; line-height: 1.6; padding: 10px 0;">
                        {{ $statusNote }}
                    </div>
                </div>
            @endif

            <!-- Order Details -->
            <div class="order-details">
                <div class="detail-row">
                    <span class="detail-label">Order Total</span>
                    <span class="detail-value">${{ number_format($order->total, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Payment Method</span>
                    <span
                        class="detail-value">{{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'N/A')) }}</span>
                </div>
                @if ($order->shipping)
                    @php $shipping = json_decode($order->shipping); @endphp
                    <div class="detail-row">
                        <span class="detail-label">Shipping Address</span>
                        <span class="detail-value" style="text-align: right;">
                            {{ $shipping->address ?? '' }}<br>
                            {{ $shipping->city ?? '' }}, {{ $shipping->state ?? '' }} {{ $shipping->zip ?? '' }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="divider"></div>

            <!-- Call to Action -->
            <div class="button-container">
                {{-- <a href="{{ url('/user/orders/' . $order->id) }}" class="cta-button">
                    View Order Details
                </a> --}}
                <a href="{{ url('/') }}" class="cta-button">
                    View Order Details
                </a>
            </div>

            <div class="message" style="margin-top: 30px; font-size: 14px;">
                If you have any questions or concerns about your order, please don't hesitate to reach out to our
                customer support team. We're always happy to help!
            </div>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-text">
                Thank you for choosing us! 🙏
            </div>
            <div class="footer-text">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </div>
            <div class="footer-links">
                <a href="{{ url('/') }}" class="footer-link">Visit Store</a>
                <a href="{{ url('/contact') }}" class="footer-link">Contact Support</a>
                <a href="{{ url('/user/orders') }}" class="footer-link">My Orders</a>
            </div>
            <div class="footer-text" style="margin-top: 15px; font-size: 12px;">
                This is an automated email. Please do not reply to this message.
            </div>
        </div>
    </div>
</body>

</html>
