<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Order - Afrikart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            padding: 20px 0;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            overflow: hidden;
        }

        /* Header Section */
        .header {
            background: #2C2C2C;
            color: #ffffff;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
        }

        .logo-icon {
            width: 24px;
            height: 24px;
            background: #F5A623;
            border-radius: 4px;
            margin-right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .logo-text {
            font-size: 18px;
            font-weight: 600;
            color: #ffffff;
        }

        .header-title {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .header-subtitle {
            font-size: 16px;
            color: #cccccc;
            margin-bottom: 25px;
            line-height: 1.4;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        .track-button {
            background: #F5A623;
            color: #2C2C2C;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            display: inline-block;
            margin-top: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(245, 166, 35, 0.3);
        }

        .track-button:hover {
            background: #E6961F;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(245, 166, 35, 0.4);
        }

        .track-info {
            font-size: 14px;
            color: #cccccc;
            margin-top: 15px;
        }

        /* Zigzag Border */
        .zigzag-border {
            height: 20px;
            background:
                linear-gradient(45deg, transparent 33.33%, #2C2C2C 33.33%, #2C2C2C 66.66%, transparent 66.66%),
                linear-gradient(-45deg, transparent 33.33%, #2C2C2C 33.33%, #2C2C2C 66.66%, transparent 66.66%);
            background-size: 20px 40px;
            background-position: 0 0, 10px 0;
        }

        /* Content Section */
        .content {
            padding: 40px 30px;
            background: #ffffff;
        }

        .summary-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            gap: 30px;
        }

        .summary-left,
        .summary-right {
            flex: 1;
        }

        .section-title {
            font-size: 20px;
            font-weight: 600;
            color: #F5A623;
            margin-bottom: 15px;
        }

        .status-badge {
            background: #F5A623;
            color: #2C2C2C;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
            display: inline-block;
        }

        .order-info {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .order-total {
            font-size: 18px;
            font-weight: 600;
            color: #2C2C2C;
            margin-top: 8px;
        }

        .address-info {
            font-size: 14px;
            color: #2C2C2C;
            line-height: 1.5;
        }

        .customer-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* Items Section */
        .items-section {
            margin: 40px 0;
        }

        .items-title {
            font-size: 24px;
            font-weight: 600;
            color: #2C2C2C;
            text-align: center;
            margin-bottom: 10px;
        }

        .order-number {
            text-align: center;
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
        }

        .item {
            display: flex;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 20px;
            border: 1px solid #f0f0f0;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 16px;
            font-weight: 600;
            color: #2C2C2C;
            margin-bottom: 5px;
        }

        .item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .item-price {
            font-size: 16px;
            font-weight: 600;
            color: #10b981;
        }

        /* Totals Section */
        .totals-section {
            border-top: 2px solid #f0f0f0;
            padding-top: 20px;
            margin-top: 30px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }

        .total-row.final {
            border-top: 2px solid #2C2C2C;
            margin-top: 15px;
            padding-top: 15px;
            font-weight: 700;
            font-size: 18px;
            color: #2C2C2C;
        }

        .discount-row {
            color: #10b981;
        }

        /* Support Section */
        .support-section {
            background: #f9f9f9;
            padding: 30px;
            margin: 40px 0;
            border-radius: 8px;
            text-align: center;
        }

        .support-title {
            font-size: 20px;
            font-weight: 600;
            color: #2C2C2C;
            margin-bottom: 20px;
        }

        .support-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .support-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 15px 25px;
            background: #F5A623;
            color: #2C2C2C;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            min-width: 160px;
            text-align: center;
        }

        .support-btn:hover {
            background: #E6961F;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(245, 166, 35, 0.3);
        }

        .support-btn.secondary {
            background: #2C2C2C;
            color: #ffffff;
        }

        .support-btn.secondary:hover {
            background: #1a1a1a;
            box-shadow: 0 4px 15px rgba(44, 44, 44, 0.3);
        }

        /* Referral Section */
        .referral-section {
            background: #2C2C2C;
            color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin: 30px 0;
        }

        .referral-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .referral-description {
            font-size: 16px;
            color: #cccccc;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .referral-link {
            background: #333;
            color: #cccccc;
            padding: 12px 16px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 14px;
            margin: 15px 0;
            display: inline-block;
            border: 1px solid #555;
        }

        .share-btn {
            background: #F5A623;
            color: #2C2C2C;
            padding: 12px 25px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            margin-left: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(245, 166, 35, 0.3);
        }

        .share-btn:hover {
            background: #E6961F;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(245, 166, 35, 0.4);
        }

        /* Business Section */
        .business-section {
            background: #FFF8E1;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .business-icon {
            width: 50px;
            height: 50px;
            background: #2C2C2C;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 20px;
        }

        .business-content h3 {
            font-size: 18px;
            font-weight: 600;
            color: #2C2C2C;
            margin-bottom: 5px;
        }

        .business-content p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }

        .business-email {
            color: #F5A623;
            text-decoration: none;
            font-weight: 600;
        }

        /* Footer Section */
        .footer {
            background: #2C2C2C;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .footer-logo .logo-icon {
            background: #F5A623;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
        }

        .social-link {
            width: 35px;
            height: 35px;
            background: #444;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        .social-link:hover {
            background: #F5A623;
            color: #2C2C2C;
        }

        .footer-address {
            font-size: 14px;
            color: #cccccc;
            margin: 15px 0;
            line-height: 1.5;
        }

        .unsubscribe-link {
            color: #F5A623;
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
            display: inline-block;
            font-weight: 500;
        }

        .unsubscribe-link:hover {
            text-decoration: underline;
            color: #E6961F;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
            }

            .header,
            .content,
            .footer {
                padding: 25px 20px;
            }

            .summary-section {
                flex-direction: column;
                gap: 20px;
            }

            .support-buttons {
                flex-direction: column;
                align-items: center;
            }

            .support-btn {
                width: 100%;
                justify-content: center;
            }

            .business-section {
                flex-direction: column;
                text-align: center;
            }

            .social-links {
                flex-wrap: wrap;
            }

            .referral-title {
                font-size: 20px;
            }

            .items-title {
                font-size: 20px;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .email-container {
                box-shadow: none;
                max-width: none;
            }

            .track-button,
            .support-buttons,
            .share-btn,
            .social-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <div class="logo-icon">🎨</div>
                <div class="logo-text">Afrikart</div>
            </div>
            <h1 class="header-title">Thank You for Order</h1>
            <p class="header-subtitle">Your order's in. We're working to get it packed up and out the door expect a
                dispatch confirmation email soon.</p>
            <a href="{{ route('orders.track', $order->id) }}" class="track-button">Track Your Order</a>
            <p class="track-info">Please allow 24 hours to track your order.</p>
        </div>

        <!-- Zigzag Border -->
        <div class="zigzag-border"></div>

        <!-- Content -->
        <div class="content">
            <!-- Summary Section -->
            <div class="summary-section">
                <div class="summary-left">
                    <h2 class="section-title">Summary</h2>
                    <div class="status-badge">Ready to Ship</div>
                    <div class="order-info">#{{ $order->id }} - {{ $order->created_at->format('M d, Y') }}</div>
                    <div class="order-total">${{ number_format($order->total, 2) }}</div>
                </div>
                <div class="summary-right">
                    <h2 class="section-title">Shipping Address</h2>
                    @php
                        $shipping = $order->shipping;
                        if (is_string($shipping)) {
                            $shipping = json_decode($shipping, true);
                        } elseif (!is_array($shipping)) {
                            $shipping = [];
                        }
                    @endphp
                    <div class="address-info">
                        <div class="customer-name">{{ $shipping['first_name'] ?? ($order->first_name ?? 'N/A') }}
                            {{ $shipping['last_name'] ?? ($order->last_name ?? '') }}</div>
                        <div>{{ $shipping['address'] ?? 'N/A' }}</div>
                        <div>
                            {{ $shipping['city'] ?? '' }}{{ !empty($shipping['city']) && !empty($shipping['state']) ? ', ' : '' }}{{ $shipping['state'] ?? '' }}
                            {{ $shipping['zip'] ?? '' }}</div>
                        @if (!empty($shipping['country']))
                            <div>{{ $shipping['country'] }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="items-section">
                <h2 class="items-title">Your item in this order</h2>
                <div class="order-number">Order number: #{{ $order->id }}</div>

                @if ($order->childs && $order->childs->count() > 0)
                    @foreach ($order->childs as $item)
                        <div class="item">
                            @if ($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                    alt="{{ $item->product->name }}" class="item-image">
                            @else
                                <div class="item-image"
                                    style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                                    No Image</div>
                            @endif
                            <div class="item-details">
                                <div class="item-name">{{ $item->product->name ?? 'Product' }}</div>
                                <div class="item-description">
                                    @if ($item->variation)
                                        {{ $item->variation }}
                                    @else
                                        Premium quality, handcrafted item
                                    @endif
                                </div>
                                <div class="item-price">${{ number_format($item->product_price, 2) }}</div>
                            </div>
                        </div>
                    @endforeach
                @elseif($order->product)
                    <div class="item">
                        @if ($order->product->image)
                            <img src="{{ asset('storage/' . $order->product->image) }}"
                                alt="{{ $order->product->name }}" class="item-image">
                        @else
                            <div class="item-image"
                                style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; color: #999;">
                                No Image</div>
                        @endif
                        <div class="item-details">
                            <div class="item-name">{{ $order->product->name }}</div>
                            <div class="item-description">
                                @if ($order->variation)
                                    {{ $order->variation }}
                                @else
                                    Premium quality, handcrafted item
                                @endif
                            </div>
                            <div class="item-price">${{ number_format($order->product_price, 2) }}</div>
                        </div>
                    </div>
                @endif

                <!-- Totals -->
                <div class="totals-section">
                    <div class="total-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->product_price ?? 0, 2) }}</span>
                    </div>

                    @if ($order->discount_amount > 0)
                        <div class="total-row discount-row">
                            <span>Discount</span>
                            <span>-${{ number_format($order->discount_amount, 2) }}</span>
                        </div>
                    @endif

                    @if ($order->shipping_total > 0)
                        <div class="total-row">
                            <span>Standard Delivery</span>
                            <span>${{ number_format($order->shipping_total, 2) }}</span>
                        </div>
                    @else
                        <div class="total-row">
                            <span>Standard Delivery</span>
                            <span>FREE</span>
                        </div>
                    @endif

                    <div class="total-row final">
                        <span>Total:</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Support Section -->
            <div class="support-section">
                <h3 class="support-title">Any problems with your order?</h3>
                <div class="support-buttons">
                    <a href="mailto:help@afrikartt.com" class="support-btn">
                        📧 Email Us
                        <br><span style="font-size: 12px; font-weight: normal;">help@Afrikart.com</span>
                    </a>
                    <a href="tel:+1234567890" class="support-btn secondary">
                        📞 Call Us
                        <br><span style="font-size: 12px; font-weight: normal;">+1 (234) 567-8900</span>
                    </a>
                </div>
            </div>

            <!-- Referral Section -->
            <div class="referral-section">
                <h3 class="referral-title">$30 for you, $30 for a friend</h3>
                <p class="referral-description">Share the link below and you'll get every friend who places an order
                    over $60. Easy peasy.</p>
                <div class="referral-link">https://afrikartt.com/?ref={{ $order->user_id ?? 'guest' }}</div>
                <a href="#" class="share-btn">Share Link</a>
            </div>

            <!-- Business Section -->
            <div class="business-section">
                <div class="business-icon">✉️</div>
                <div class="business-content">
                    <h3>Want to talk business with us?</h3>
                    <p>Feel free to reach out to us at <a href="mailto:partner@afrikartt.com"
                            class="business-email">partner@afrikartt.com</a><br>
                        We open opportunities for all forms of business collaboration.</p>
                </div>
            </div>
        </div>

        <!-- Zigzag Border -->
        <div class="zigzag-border" style="transform: rotate(180deg);"></div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-logo">
                <div class="logo-icon">🎨</div>
                <div class="logo-text">Afrikart</div>
            </div>

            <div class="social-links">
                <a href="#" class="social-link">📘</a>
                <a href="#" class="social-link">📸</a>
                <a href="#" class="social-link">🐦</a>
                <a href="#" class="social-link">📌</a>
                <a href="#" class="social-link">📺</a>
            </div>

            <div class="footer-address">
                Afrikart HQ, 123 Creative Street Unit 10<br>
                Accra, Ghana 00233
            </div>

            <a href="#" class="unsubscribe-link">Unsubscribe</a>
        </div>
    </div>
</body>

</html>
