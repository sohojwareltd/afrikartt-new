<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation - {{ $order->order_id ?? 'Thank You for Your Order!' }}</title>
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        /* Header Section */
        .email-header {
            background: #DE991B;
            color: white;
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }

        .email-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .logo-section {
            position: relative;
            z-index: 2;
            margin-bottom: 25px;
        }

        .logo {
            width: 140px;
            height: auto;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
        }

        .success-icon {
            font-size: 60px;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .header-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .header-subtitle {
            font-size: 18px;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .order-number {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
            margin-top: 20px;
            position: relative;
            z-index: 2;
        }

        /* Main Content */
        .email-body {
            padding: 40px 30px;
        }

        .thank-you-section {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: center;
        }

        .thank-you-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }

        .thank-you-title {
            font-size: 26px;
            font-weight: 700;
            color: #155724;
            margin-bottom: 15px;
        }

        .thank-you-message {
            color: #155724;
            font-size: 16px;
            line-height: 1.6;
            max-width: 500px;
            margin: 0 auto;
        }

        /* Order Summary Section - Improved Design */
        .order-summary-section {
            background: linear-gradient(135deg, #fff8f0 0%, #ffffff 100%);
            /* border: 1px solid #DE991B; */
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(222, 153, 27, 0.1);
            position: relative;
            overflow: hidden;
        }

        .simple-order-info {
            margin-bottom: 20px;
        }

        .simple-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            margin-bottom: 8px;
            background: white;
            border-radius: 10px;
            border: 1px solid #f1f3f4;
            transition: all 0.3s ease;
            position: relative;
        }

        .simple-info-row:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(222, 153, 27, 0.15);
            border-color: #DE991B;
        }

        .simple-info-row:last-child {
            margin-bottom: 0;
        }

        .simple-info-label {
            font-size: 15px;
            color: #666;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .simple-info-label::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #DE991B;
            border-radius: 50%;
            margin-right: 10px;
        }

        .simple-info-value {
            font-size: 15px;
            color: #333;
            font-weight: 700;
        }

        .simple-status-badge {
            background: linear-gradient(135deg, #DE991B 0%, #f4a442 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(222, 153, 27, 0.3);
            position: relative;
            overflow: hidden;
        }

        .simple-status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .simple-status-badge:hover::before {
            left: 100%;
        }

        .order-summary-icon {
            background: linear-gradient(135deg, #DE991B 0%, #f4a442 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-right: 15px;
            box-shadow: 0 4px 15px rgba(222, 153, 27, 0.3);
        }

        .section-title-improved {
            font-size: 24px;
            font-weight: 800;
            color: #333;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            position: relative;
        }

        .section-title-improved::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 65px;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #DE991B, #f4a442);
            border-radius: 2px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #DE991B;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
        }

        .section-icon {
            font-size: 26px;
            margin-right: 12px;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border-left: 4px solid #DE991B;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-3px);
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            line-height: 1.4;
        }

        .price-value {
            color: #DE991B;
            font-size: 20px;
            font-weight: 700;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        /* Order Items Section */
        .items-section {
            margin-bottom: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .items-table th {
            background: #DE991B;
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .items-table td {
            padding: 20px 15px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .items-table tr:hover {
            background: #f8f9fa;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-image {
            width: 70px;
            height: 70px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #e9ecef;
        }

        .product-details h6 {
            margin: 0 0 6px 0;
            font-weight: 600;
            font-size: 16px;
            color: #333;
        }

        .product-details p {
            margin: 0;
            font-size: 13px;
            color: #6c757d;
            line-height: 1.4;
        }

        .quantity-display {
            background: #DE991B;
            color: white;
            padding: 8px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            min-width: 50px;
        }

        .price-cell {
            text-align: right;
            font-weight: 600;
            font-size: 15px;
        }

        /* Order Total Section */
        .order-total-section {
            background: white;
            border: 2px solid #DE991B;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .total-breakdown {
            margin-bottom: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .total-row:last-child {
            border-bottom: none;
            padding-top: 15px;
            margin-top: 10px;
            border-top: 2px solid #DE991B;
        }

        .total-row.grand-total {
            font-size: 18px;
            font-weight: 700;
            color: #DE991B;
        }

        .total-label {
            font-size: 15px;
            color: #333;
        }

        .total-value {
            font-size: 15px;
            font-weight: 600;
            color: #333;
        }

        /* Shipping Information */
        .shipping-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .shipping-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .shipping-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        /* Order Tracking Section */
        .tracking-section {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .tracking-title {
            font-size: 20px;
            font-weight: 700;
            color: #e65100;
            margin-bottom: 15px;
        }

        .tracking-message {
            color: #e65100;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .tracking-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 500px;
            margin: 0 auto;
            position: relative;
        }

        .tracking-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            flex: 1;
        }

        .step-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid #ff9800;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #ff9800;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .step-icon.active {
            background: #ff9800;
            color: white;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: #e65100;
            text-align: center;
        }

        .step-line {
            position: absolute;
            top: 25px;
            left: 50%;
            right: -50%;
            height: 3px;
            background: #ffcc80;
            z-index: 1;
        }

        .tracking-step:last-child .step-line {
            display: none;
        }

        /* Action Buttons */
        .action-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .action-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .action-subtitle {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 25px;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 14px 28px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 180px;
            justify-content: center;
        }

        .btn-primary {
            background: #DE991B;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(222, 153, 27, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
            color: white;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #DE991B;
            color: #DE991B;
        }

        .btn-outline:hover {
            background: #DE991B;
            color: white;
            transform: translateY(-3px);
        }

        /* Customer Support */
        .support-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .support-title {
            font-size: 20px;
            font-weight: 700;
            color: #6a1b9a;
            margin-bottom: 15px;
        }

        .support-message {
            color: #6a1b9a;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .support-contacts {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .support-contact {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            color: #6a1b9a;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.3s ease;
        }

        .support-contact:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(106, 27, 154, 0.2);
        }

        /* Newsletter Section */
        .newsletter-section {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .newsletter-title {
            font-size: 20px;
            font-weight: 700;
            color: #2e7d32;
            margin-bottom: 10px;
        }

        .newsletter-message {
            color: #2e7d32;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .newsletter-form {
            display: flex;
            gap: 10px;
            max-width: 400px;
            margin: 0 auto;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 15px;
            border: 2px solid #4caf50;
            border-radius: 6px;
            font-size: 14px;
        }

        .newsletter-btn {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Footer */
        .email-footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 35px 30px;
            text-align: center;
        }

        .footer-content {
            margin-bottom: 25px;
        }

        .footer-title {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .footer-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .footer-links {
            margin-bottom: 25px;
        }

        .footer-links a {
            color: #ecf0f1;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #DE991B;
        }

        .footer-social {
            margin-bottom: 20px;
        }

        .social-link {
            color: #ecf0f1;
            font-size: 20px;
            margin: 0 10px;
            text-decoration: none;
        }

        .footer-contact {
            font-size: 12px;
            color: #bdc3c7;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }

            .email-header,
            .email-body {
                padding: 25px 20px;
            }

            .header-title {
                font-size: 26px;
            }

            .thank-you-title {
                font-size: 22px;
            }

            .order-info-grid,
            .shipping-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 280px;
            }

            .items-table {
                font-size: 12px;
            }

            .items-table th,
            .items-table td {
                padding: 12px 8px;
            }

            .product-image {
                width: 50px;
                height: 50px;
            }

            .tracking-steps {
                flex-direction: column;
                gap: 15px;
            }

            .step-line {
                display: none;
            }

            .newsletter-form {
                flex-direction: column;
            }

            .support-contacts {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="email-header">
            <div class="logo-section">
                @if (Settings::setting('site_logo'))
                    <img src="{{ Settings::setting('site_logo') }}" alt="Royalit Logo" class="logo">
                @else
                    <div style="font-size: 28px; font-weight: bold; color: white; position: relative; z-index: 2;">
                        Royalit</div>
                @endif
            </div>
            <h1 class="header-title">Order Confirmed!</h1>
            <p class="header-subtitle">Thank you for shopping with us</p>
            <div class="order-number">Order #{{ $order->id ?? 'AF-' . date('Ymd') . '-' . rand(1000, 9999) }}</div>
        </div>

        <!-- Main Content -->
        <div class="email-body">
            <!-- Thank You Section -->
            <div class="thank-you-section">
                <div class="thank-you-icon">🎉</div>
                <h2 class="thank-you-title">Thank You, {{ $order->user->name ?? 'Valued Customer' }}!</h2>
                <p class="thank-you-message">
                    Your order has been successfully placed and confirmed. We're excited to prepare your items
                    and get them shipped to you as soon as possible. You'll receive updates about your order status
                    via email and SMS.
                </p>
            </div>

            <!-- Order Summary -->
            <div class="order-summary-section">
                <h3 class="section-title-improved">
                    <div class="order-summary-icon">📋</div>
                    Order Summary
                </h3>
                <div class="simple-order-info">
                    <div class="simple-info-row">
                        <span class="simple-info-label">Order Number</span>
                        <span
                            class="simple-info-value">#{{ $order->id ?? 'AF-' . date('Ymd') . '-' . rand(1000, 9999) }}</span>
                    </div>
                    <div class="simple-info-row">
                        <span class="simple-info-label">Order Date</span>
                        <span class="simple-info-value">
                            {{ isset($order->created_at) ? $order->created_at->format('M d, Y - H:i A') : date('M d, Y - H:i A') }}
                        </span>
                    </div>
                    <div class="simple-info-row">
                        <span class="simple-info-label">Order Status</span>
                        <span class="simple-status-badge">{{ ucfirst($order->status == 1 ? 'paid' : 'Pending') }}</span>
                    </div>
                    <div class="simple-info-row">
                        <span class="simple-info-label">Payment Method</span>
                        <span
                            class="simple-info-value">{{ ucfirst($order->payment_method ?? 'Cash on Delivery') }}</span>
                    </div>
                    <div class="simple-info-row">
                        <span class="simple-info-label">Payment Status</span>
                        <span
                            class="simple-status-badge">{{ ucfirst($order->payment_status == 1 ? 'Paid' : 'Pending') }}</span>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            @if (isset($order->childs) && count($order->childs) > 0)
                <div class="items-section">
                    <h3 class="section-title">
                        <span class="section-icon">🛒</span>
                        Your Order Items ({{ $order->products->sum('pivot.quantity') }} items)
                    </h3>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->products as $item)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            @if (isset($item->image) && $item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                    alt="{{ $item->name ?? 'Product' }}" class="product-image">
                                            @else
                                                <div
                                                    style="width: 70px; height: 70px; background: linear-gradient(135deg, #f1f3f4, #e9ecef); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #6c757d; border: 2px solid #e9ecef;">
                                                    📦
                                                </div>
                                            @endif
                                            <div class="product-details">
                                                <h6>{{ $item->name ?? ($item->name ?? 'Product Name') }}</h6>
                                                @if (isset($item->sku) && $item->sku)
                                                    <p>SKU: {{ $item->sku }}</p>
                                                @endif
                                                @if (isset($item->brand) && $item->brand)
                                                    <p>Brand: {{ $item->brand }}</p>
                                                @endif
                                                @if (isset($item->category) && $item->category)
                                                    <p>Category: {{ $item->category->name ?? 'N/A' }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="quantity-display">{{ $item->pivot->quantity ?? 1 }}</div>
                                    </td>

                                    <td class="price-cell">
                                        ${{ number_format($item->sale_price ?? $item->price, 2) }}
                                    </td>

                                    <td class="price-cell">
                                        ${{ number_format(($item->sale_price ?? $item->price) * ($item->pivot->quantity ?? 1), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Order Total -->
            <div class="order-total-section">
                <h3 class="section-title">
                    <span class="section-icon">💰</span>
                    Order Total
                </h3>
                <div class="total-breakdown">
                    <div class="total-row">
                        <span class="total-label">Subtotal</span>
                        <span class="total-value">${{ number_format($order->subtotal ?? 0, 2) }}</span>
                    </div>
                    <div class="total-row">
                        <span class="total-label">Shipping</span>
                        <span class="total-value">${{ number_format($order->shipping_total ?? 0, 2) }}</span>
                    </div>
                    {{-- <div class="total-row">
                        <span class="total-label">Tax</span>
                        <span class="total-value">${{ number_format($order->tax ?? 0, 2) }}</span>
                    </div> --}}
                    @if (isset($order->discount) && $order->discount > 0)
                        <div class="total-row">
                            <span class="total-label">Discount</span>
                            <span class="total-value">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="total-row grand-total">
                        <span class="total-label">Total</span>
                        <span class="total-value price-value">${{ number_format($order->total ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="shipping-section">
                <h3 class="section-title">
                    <span class="section-icon">🚚</span>
                    Shipping Information
                </h3>
                <div class="shipping-grid">
                    <div class="shipping-card">
                        <div class="info-label">Shipping Address</div>
                        @php
                            $shipping = $order->shipping;
                            if (is_string($shipping)) {
                                $shipping = json_decode($shipping, true);
                            } elseif (!is_array($shipping)) {
                                $shipping = [];
                            }
                        @endphp
                        <div class="info-value">
                            {{ $shipping['first_name'] ?? ($order->first_name ?? 'N/A') }}
                            {{ $shipping['last_name'] ?? ($order->last_name ?? '') }}<br>
                            {{ $shipping['address_1'] ?? ($order->address_1 ?? 'N/A') }}<br>
                            {{ $shipping['city'] ?? ($order->city ?? '') }},
                            {{ $shipping['state'] ?? ($order->state ?? '') }}
                            {{ $shipping['post_code'] ?? ($order->post_code ?? '') }}<br>
                            {{ $shipping['country'] ?? ($order->country ?? 'N/A') }}
                        </div>
                    </div>
                    <div class="shipping-card">
                        <div class="info-label">Contact Information</div>
                        <div class="info-value">
                            {{ $shipping['email'] ?? ($order->email ?? 'N/A') }}<br>
                            {{ $shipping['phone'] ?? ($order->phone ?? 'N/A') }}
                        </div>
                    </div>
                    <div class="shipping-card">
                        <div class="info-label">Shipping Method</div>
                        <div class="info-value">{{ $order->shipping_method ?? 'Standard Delivery' }}</div>
                    </div>
                    {{-- <div class="shipping-card">
                        <div class="info-label">Estimated Delivery</div>
                        <div class="info-value">
                            {{ isset($order->expected_delivery) ? $order->expected_delivery : date('M d, Y', strtotime('+5 days')) }}
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Order Tracking -->
            <div class="tracking-section">
                <h3 class="tracking-title">Track Your Order</h3>
                <p class="tracking-message">Your order is being processed. Here's what happens next:</p>
                <div class="tracking-steps">
                    <div class="tracking-step">
                        <div class="step-icon active">✅</div>
                        <div class="step-label">Order Confirmed</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="tracking-step">
                        <div class="step-icon">📦</div>
                        <div class="step-label">Processing</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="tracking-step">
                        <div class="step-icon">🚚</div>
                        <div class="step-label">Shipped</div>
                        <div class="step-line"></div>
                    </div>
                    <div class="tracking-step">
                        <div class="step-icon">🏠</div>
                        <div class="step-label">Delivered</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            {{-- <div class="action-section">
                <h3 class="action-title">What's Next?</h3>
                <p class="action-subtitle">Manage your order and explore more products</p>
                <div class="btn-group">

                    <a href="#" class="btn btn-primary">
                        <span>📱</span> Track Your Order
                    </a>


                    <a href="#" class="btn btn-secondary">
                        <span>👤</span> View Account
                    </a>

                    <a href="#" class="btn btn-outline">
                        <span>🛍️</span> Continue Shopping
                    </a>

                </div>
            </div> --}}

            <!-- Customer Support -->
            <div class="support-section">
                <h4 class="support-title">Need Help?</h4>
                <p class="support-message">Our customer support team is here to assist you with any questions or
                    concerns.</p>
                <div class="support-contacts">
                    <a href="mailto:{{ $order->shop->email ?? 'support@royalit.com' }}" class="support-contact">
                        <span>📧</span> Email Support
                    </a>
                    <a href="tel:{{ $order->shop->phone ?? '+1234567890' }}" class="support-contact">
                        <span>📞</span> Call Us
                    </a>
                    <a href="{{ url('/contact') }}" class="support-contact">
                        <span>❓</span> Help Center
                    </a>
                </div>
            </div>

            <!-- Newsletter Signup -->
            {{-- <div class="newsletter-section">
                <h4 class="newsletter-title">Stay Updated!</h4>
                <p class="newsletter-message">Get exclusive deals, new product alerts, and order updates.</p>
                <form class="newsletter-form" action="{{ url('/newsletter/subscribe') }}" method="POST">
                    @csrf
                    <input type="email" name="email" value="{{ $order->email ?? '' }}" class="newsletter-input"
                        placeholder="Enter your email" required>
                    <button type="submit" class="newsletter-btn">Subscribe</button>
                </form>
            </div> --}}

            <!-- Special Notes -->
            @if (isset($order->notes) && $order->notes)
                <div
                    style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                    <h4 style="color: #856404; margin-bottom: 15px; display: flex; align-items: center;">
                        <span style="margin-right: 10px;">📝</span> Special Instructions
                    </h4>
                    <p style="color: #856404; margin: 0; font-size: 14px; line-height: 1.5;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <h4 class="footer-title">Royalit E-commerce</h4>
                <p class="footer-subtitle">Your trusted online shopping destination</p>
            </div>
            {{-- <div class="footer-social">
                <a href="#" class="social-link">📘</a>
                <a href="#" class="social-link">📷</a>
                <a href="#" class="social-link">🐦</a>
                <a href="#" class="social-link">💼</a>
            </div> --}}
            <div class="footer-links">
                <a href="{{ url('/') }}">Shop</a>
                <a href="{{ url('/user/dashboard') }}">My Account</a>
                <a href="{{ url('/contact') }}">Contact Us</a>
            </div>
            <div class="footer-contact">
                <p>Questions about your order? Reply to this email or contact our support team.</p>
                <p>© {{ date('Y') }} Royalit E-commerce. All rights reserved.</p>
                <p>You received this email because you placed an order with us. This is a transactional email.</p>
            </div>
        </div>
    </div>
</body>

</html>
