<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Your Order - Royalit</title>
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
            width: 124px;
            height: 53px;
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
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }

        .items-title {
            font-size: 28px;
            font-weight: 700;
            color: #2C2C2C;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .order-number {
            text-align: center;
            font-size: 15px;
            color: #888;
            margin-bottom: 35px;
            font-weight: 500;
        }

        .items-container {
            background: #fafafa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .item {
            display: flex;
            align-items: center;
            padding: 25px 0;
            border-bottom: 1px solid #e8e8e8;
            transition: all 0.2s ease;
        }

        .item:hover {
            background: #f8f9fa;
            margin: 0 -15px;
            padding: 25px 15px;
            border-radius: 8px;
        }

        .item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 65px;
            height: 65px;
            border-radius: 12px;
            object-fit: cover;
            margin-right: 25px;
            border: 2px solid #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .item-image:hover {
            transform: scale(1.05);
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 18px;
            font-weight: 700;
            color: #2C2C2C;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .item-description {
            font-size: 14px;
            color: #777;
            margin-bottom: 12px;
            line-height: 1.4;
            background: #f0f8ff;
            padding: 6px 12px;
            border-radius: 15px;
            display: inline-block;
            border-left: 3px solid #F5A623;
        }

        .item-meta {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 8px;
        }

        .item-quantity {
            background: #2C2C2C;
            color: #fff;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .item-shop {
            background: #10b981;
            color: #fff;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
        }

        .item-price {
            font-size: 20px;
            font-weight: 800;
            color: #F5A623;
            text-shadow: 0 1px 2px rgba(245, 166, 35, 0.2);
        }

        .no-image-placeholder {
            background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
        <div class="header" style="background: #F5A623; color: #2C2C2C;">
            <div class="logo">
                <div class="logo-icon" style="background: #fff; color: #F5A623;"><img
                        src="{{ Settings::setting('site_logo') }}" alt="Logo" style="height: 40px;"></div>
                {{-- <div class="logo-text" style="color: #2C2C2C;">Royalit</div> --}}
            </div>
            <h1 class="header-title" style="color: #2C2C2C;">Thank You for Your Order</h1>
            <p class="header-subtitle" style="color: #6d4c00;">
                Your order's in. We're working to get it packed up and out the door. Expect a dispatch confirmation
                email soon.
            </p>
        </div>


        <!-- Content -->
        <div class="content">
            <!-- Summary Section -->
            <div
                style="padding: 24px 16px; background: #f7f7f7; border-radius: 8px; margin-bottom: 32px; display: flex; flex-wrap: wrap; gap: 24px;">
                <div style="flex: 1 1 220px; min-width: 220px;">
                    <h3 style="font-size: 18px; color: #222; margin-bottom: 10px;">Order Info</h3>
                    <div style="font-size: 15px; color: #444; margin-bottom: 6px;">
                        <strong>Order #{{ $childOrder->id }}</strong>
                    </div>
                    <div style="font-size: 14px; color: #888; margin-bottom: 6px;">
                        Placed: {{ $childOrder->created_at->format('M d, Y') }}
                    </div>
                    <div style="font-size: 15px; color: #222; margin-bottom: 6px;">
                        Status: <span
                            style="color: #10b981; font-weight: 600;">{{ ucfirst($childOrder->status == 0 ? 'pending' : ($childOrder->status == 1 ? 'paid' : ($childOrder->status == 2 ? 'on its way' : ($childOrder->status == 3 ? 'cancelled' : 'delivered')))) }}</span>
                    </div>
                    <div style="font-size: 16px; color: #F5A623; font-weight: 700;">
                        Total: {{ Sohoj::price($childOrder->total) }}
                    </div>
                </div>
                <div style="flex: 1 1 220px; min-width: 220px;">
                    <h3 style="font-size: 18px; color: #222; margin-bottom: 10px;">Shipping To</h3>
                    @php
                        $shipping = $childOrder->shipping;
                        if (is_string($shipping)) {
                            $shipping = json_decode($shipping, true);
                        } elseif (!is_array($shipping)) {
                            $shipping = [];
                        }
                    @endphp
                    <div style="font-size: 15px; color: #222; font-weight: 600;">
                        {{ $shipping['first_name'] ?? ($order->first_name ?? 'N/A') }}
                        {{ $shipping['last_name'] ?? ($order->last_name ?? '') }}
                    </div>
                    <div style="font-size: 14px; color: #444;">
                        {{ $shipping['address'] ?? 'N/A' }}
                    </div>
                    <div style="font-size: 14px; color: #444;">
                        {{ $shipping['city'] ?? '' }}{{ !empty($shipping['city']) && !empty($shipping['state']) ? ', ' : '' }}{{ $shipping['state'] ?? '' }}
                        {{ $shipping['zip'] ?? '' }}
                    </div>
                    @if (!empty($shipping['country']))
                        <div style="font-size: 14px; color: #444;">
                            {{ $shipping['country'] }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Items Section -->
            <div class="items-section">
                <h2 class="items-title">Your item in this order</h2>
                <div class="order-number">Order number: #{{ $childOrder->id }}</div>

                <div class="items-container">

                    <div class="item">
                        @if ($childOrder->product->image)
                            <img src="{{ asset('storage/' . $childOrder->product->image) }}"
                                alt="{{ $childOrder->product->name }}" class="item-image">
                        @else
                            <div class="item-image no-image-placeholder">No Image</div>
                        @endif
                        <div class="item-details">
                            <div class="item-name">{{ $childOrder->product->name }}</div>
                            <div class="item-meta">
                                <span class="item-quantity">Qty: {{ $childOrder->quantity ?? 1 }}</span>
                                <span class="item-shop">{{ $childOrder->shop->name ?? 'N/A' }}</span>
                            </div>
                            @if ($childOrder->variation)
                                <div class="item-description">{{ $childOrder->variation }}</div>
                            @else
                                {{-- <div class="item-description">Premium quality, handcrafted item</div> --}}
                            @endif
                            <div class="item-price">${{ number_format($childOrder->product_price, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Totals -->
                <div style="margin-top: 30px; padding: 18px 0; border-top: 1px solid #eee;">
                    <table width="100%" cellpadding="0" cellspacing="0" style="font-size: 15px; color: #222;">
                        <tr>
                            <td style="padding: 6px 0;">Vendor fee</td>
                            <td style="padding: 6px 0; text-align: right;">
                                {{ Sohoj::price($childOrder->vendor_total) }}
                            </td>
                        </tr>
                        {{-- @if ($order->discount_amount > 0) --}}
                        <tr>
                            <td style="padding: 6px 0; color: #10b981;">Platform fee</td>
                            <td style="padding: 6px 0; text-align: right; color: #10b981;">
                                {{ Sohoj::price($childOrder->platform_fee) }}
                            </td>
                        </tr>
                        {{-- @dd($order) --}}
                        {{-- <tr>
                            <td style="padding: 6px 0; color: #10b981;">Tax</td>
                            <td style="padding: 6px 0; text-align: right; color: #10b981;">
                                {{ Sohoj::price(Sohoj::tax()) }}
                            </td>
                        </tr> --}}
                        @if (session()->has('discount'))
                            <tr>
                                <td style="padding: 6px 0; color: #10b981;">Discount</td>
                                <td style="padding: 6px 0; text-align: right; color: #10b981;">
                                    {{ Sohoj::price(Sohoj::discount()) }}
                                </td>
                            </tr>
                        @endif
                        {{-- @endif --}}
                        <tr>
                            <td style="padding: 6px 0;">Shipping</td>
                            <td style="padding: 6px 0; text-align: right;">
                                {{ Sohoj::price($childOrder->shipping_total) }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 10px 0; font-weight: bold; border-top: 2px solid #222;">Total</td>
                            <td
                                style="padding: 10px 0; text-align: right; font-weight: bold; border-top: 2px solid #222;">
                                {{ Sohoj::price($childOrder->total) }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Support Section -->
            <div
                style="background: #f8f9fa; border: 1px solid #eee; border-radius: 6px; padding: 20px; margin: 32px 0; text-align: left;">
                <h3 style="font-size: 18px; color: #2C2C2C; margin-bottom: 10px;">Need Help?</h3>
                <p style="font-size: 14px; color: #444; margin-bottom: 12px;">
                    If you have any questions or issues with your order, our support team is here to help.
                </p>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li style="margin-bottom: 8px;">
                        <strong>Email:</strong>
                        <a href="mailto:{{ Settings::setting('site_email') }}"
                            style="color: #F5A623; text-decoration: none;">{{ Settings::setting('site_email') }}</a>
                    </li>
                    <li>
                        <strong>Phone:</strong>
                        <a href="tel:{{ Settings::setting('site_phone') }}"
                            style="color: #F5A623; text-decoration: none;">{{ Settings::setting('site_phone') }}</a>
                    </li>
                </ul>
            </div>

            <!-- Referral Section -->
            {{-- <div style="background: #f0f0f0; border-radius: 6px; padding: 18px 20px; margin: 32px 0; text-align: left;">
                <h3 style="font-size: 18px; color: #2C2C2C; margin-bottom: 8px;">Refer a Friend &amp; Earn!</h3>
                <p style="font-size: 14px; color: #444; margin-bottom: 10px;">
                    Share your referral link. When a friend places their first order over $60, you both get $30 credit.
                </p>
                <div style="background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 10px 12px; font-size: 13px; color: #333; margin-bottom: 10px; word-break: break-all;">
                    https://Royalit.com/?ref={{ $order->user_id ?? 'guest' }}
                </div>
                <a href="https://Royalit.com/?ref={{ $order->user_id ?? 'guest' }}" style="display: inline-block; background: #10b981; color: #fff; padding: 8px 18px; border-radius: 20px; text-decoration: none; font-size: 14px; font-weight: 600;">
                    Copy &amp; Share
                </a>
            </div> --}}

            <!-- Business Section -->
            <div class="business-section">
                <div class="business-icon">✉️</div>
                <div class="business-content">
                    <h3>Want to talk business with us?</h3>
                    <p>Feel free to reach out to us at <a href="mailto:{{ Settings::setting('site_email') }}"
                            class="business-email">{{ Settings::setting('site_email') }}</a><br>
                        We welcome all forms of business collaboration and partnership opportunities. Let's grow
                        together with Royalit!</p>
                </div>
            </div>
        </div>

        <!-- Zigzag Border -->
        {{-- <div class="zigzag-border" style="transform: rotate(180deg);"></div> --}}

        <!-- Footer -->
        <div class="footer"
            style="background: #0d5960; color: #ffffff; padding: 24px 0; border-top: 1px solid #eee; text-align: center;">
            <div style="margin-bottom: 10px;">
                <div class="logo">
                    <div class="logo-icon" style="background: #fff; color: #F5A623;"><img
                            src="{{ Settings::setting('site_logo') }}" alt="Logo" style="height: 40px;"></div>
                </div>
            </div>
            <div style="font-size: 15px; color: #ffffff; margin-bottom: 8px;">
                &copy; {{ date('Y') }} Royalit. All rights reserved.
            </div>
            <div style="font-size: 13px; color: #ffffff; margin-bottom: 8px;">
                {{ Settings::setting('site_address', 'Royalit HQ, Accra, Ghana 00233') }}
            </div>
        </div>
    </div>
</body>

</html>
