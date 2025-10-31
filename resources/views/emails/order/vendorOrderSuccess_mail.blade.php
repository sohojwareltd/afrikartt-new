<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order for Your Store - {{ $order->order_id ?? 'Order Notification' }}</title>
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .vendor-badge {
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 8px 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .header-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }

        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .earnings-highlight {
            background: #2900009e;
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            display: inline-block;
            margin-top: 20px;
            position: relative;
            z-index: 2;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        /* Main Content */
        .email-body {
            padding: 40px 30px;
        }

        .congratulations-section {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border: 1px solid #c3e6cb;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            text-align: center;
        }

        .congrats-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .congrats-title {
            font-size: 24px;
            font-weight: 700;
            color: #155724;
            margin-bottom: 10px;
        }

        .congrats-message {
            color: #155724;
            font-size: 16px;
            line-height: 1.5;
        }

        /* Vendor Store Section */
        .vendor-store-section {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #DE991B;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .section-icon {
            font-size: 24px;
            margin-right: 12px;
        }

        .store-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .info-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
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
        }

        .price-value {
            color: #28a745;
            font-size: 20px;
            font-weight: 700;
        }

        .commission-info {
            background: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 15px;
            margin-top: 10px;
            font-size: 14px;
            color: #155724;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-new {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        /* Order Details Section */
        .order-details-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .order-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: white;
            padding: 18px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .summary-card-icon {
            font-size: 28px;
            margin-bottom: 10px;
            color: #DE991B;
        }

        .summary-card-value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .summary-card-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Your Products Section */
        .products-section {
            margin-bottom: 30px;
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .products-table th {
            background: #DE991B;
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .products-table td {
            padding: 18px 15px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
        }

        .products-table tr:last-child td {
            border-bottom: none;
        }

        .products-table tr:hover {
            background: #f8f9fa;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 15px;
            border: 2px solid #e9ecef;
        }

        .product-details h6 {
            margin: 0 0 5px 0;
            font-weight: 600;
            font-size: 15px;
            color: #333;
        }

        .product-details p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }

        .quantity-badge {
            background: #DE991B;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
        }

        .earnings-cell {
            text-align: right;
        }

        .earnings-amount {
            font-size: 16px;
            font-weight: 700;
            color: #28a745;
        }

        .commission-rate {
            font-size: 11px;
            color: #6c757d;
            margin-top: 2px;
        }

        /* Customer Information */
        .customer-section {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Action Section */
        .action-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        .action-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
        }

        .action-subtitle {
            font-size: 14px;
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
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 160px;
            justify-content: center;
        }

        .btn-primary {
            background: #DE991B;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(111, 66, 193, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20913a 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
        }

        /* Tips Section */
        .tips-section {
            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            border-left: 6px solid #ffc107;
        }

        .tips-title {
            font-size: 18px;
            font-weight: 700;
            color: #856404;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .tips-list {
            list-style: none;
            padding: 0;
        }

        .tips-list li {
            padding: 8px 0;
            color: #856404;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
        }

        .tips-list li::before {
            content: "💡";
            margin-right: 10px;
            flex-shrink: 0;
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
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .footer-subtitle {
            font-size: 14px;
            opacity: 0.9;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #ecf0f1;
            text-decoration: none;
            margin: 0 15px;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-links a:hover {
            color: #6f42c1;
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
                font-size: 24px;
            }

            .congrats-title {
                font-size: 20px;
            }

            .store-info-grid,
            .customer-grid,
            .order-summary-grid {
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

            .products-table {
                font-size: 12px;
            }

            .products-table th,
            .products-table td {
                padding: 12px 8px;
            }

            .product-image {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container">
        <!-- Header Section -->
        <div class="email-header">
            <div class="vendor-badge">🏪 Vendor Portal</div>
            <h1 class="header-title">🎉 Congratulations!</h1>
            <p class="header-subtitle">You've received a new order for your products</p>
            <div class="earnings-highlight">
                💰 You've earned ${{ number_format($childOrder->vendor_total ?? 0, 2) }}
            </div>
        </div>

        <!-- Main Content -->
        <div class="email-body">
            <!-- Congratulations Section -->
            <div class="congratulations-section">
                <div class="congrats-icon">🛍️</div>
                <h2 class="congrats-title">New Order Received!</h2>
                <p class="congrats-message">
                    Great news! A customer has purchased products from your store.
                    This order will contribute to your monthly sales and help grow your business on our platform.
                </p>
            </div>

            <!-- Vendor Store Information -->
            <div class="vendor-store-section">
                <h3 class="section-title">
                    <span class="section-icon">🏪</span>
                    Your Store Details
                </h3>
                <div class="store-info-grid">
                    <div class="info-card">
                        <div class="info-label">Store Name</div>
                        <div class="info-value">{{ $childOrder->shop->name ?? 'Your Store' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Number</div>
                        <div class="info-value">#{{ $childOrder->id ?? 'N/A' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Date</div>
                        <div class="info-value">
                            {{ isset($childOrder->created_at) ? $childOrder->created_at->format('M d, Y - H:i A') : date('M d, Y - H:i A') }}
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Your Earnings</div>
                        <div class="info-value price-value">${{ number_format($childOrder->vendor_total ?? 0, 2) }}
                        </div>
                        {{-- <div class="commission-info">
                            📊 Commission: {{ $commissionRate ?? '15' }}% platform fee already deducted
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-details-section">
                <h3 class="section-title">
                    <span class="section-icon">📋</span>
                    Order Summary
                </h3>
                <div class="order-summary-grid">
                    <div class="summary-card">
                        <div class="summary-card-icon">📦</div>
                        <div class="summary-card-value">{{ $childOrder->quantity ?? 0 }}</div>
                        <div class="summary-card-label">Items Sold</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">💵</div>
                        <div class="summary-card-value">${{ number_format($childOrder->total ?? 0, 2) }}</div>
                        <div class="summary-card-label">Order Value</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">⭐</div>
                        <div class="summary-card-value">{{ $childOrder->shop->rating ?? '0' }}</div>
                        <div class="summary-card-label">Store Rating</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-card-icon">🚀</div>
                        <div class="summary-card-value">
                            <span
                                class="status-badge status-new">{{ $childOrder->payment_status === 1 ? 'Paid' : 'Pending' }}</span>
                        </div>
                        <div class="summary-card-label">Payment Status</div>
                    </div>
                </div>
            </div>

            <!-- Your Products Sold -->

            <div class="products-section">
                <h3 class="section-title">
                    <span class="section-icon">🛒</span>
                    Your Products in This Order
                </h3>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Your Earnings</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($childOrder->products as $product)
                            <tr>
                                <td>
                                    <div class="product-info">
                                        @if (isset($product->image) && $product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name ?? 'Product' }}" class="product-image">
                                        @else
                                            <div
                                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #f1f3f4, #e9ecef); border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center; font-size: 14px; color: #6c757d; border: 2px solid #e9ecef;">
                                                📦
                                            </div>
                                        @endif
                                        <div class="product-details">
                                            <h6>{{ $product->name ?? 'Product Name' }}</h6>
                                            @if (isset($product->sku) && $product->sku)
                                                <p>SKU: {{ $product->sku }}</p>
                                            @endif
                                            @if (isset($product->category) && $product->category)
                                                <p>Category: {{ $product->category->name ?? 'N/A' }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="quantity-badge">{{ $childOrder->quantity ?? 1 }}</span>
                                </td>
                                <td>${{ number_format($product->sale_price ?? $product->price, 2) }}</td>
                                <td class="earnings-cell">
                                    <div class="earnings-amount">
                                        ${{ number_format(($product->sale_price ?? $product->price) * ($product->pivot->quantity ?? 1), 2) }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Customer Information -->
            <div class="customer-section">
                <h3 class="section-title">
                    <span class="section-icon">👤</span>
                    Customer Information
                </h3>
                @php
                    $shipping = $childOrder->shipping;
                    if (is_string($shipping)) {
                        $shipping = json_decode($shipping, true);
                    } elseif (!is_array($shipping)) {
                        $shipping = [];
                    }
                @endphp
                <div class="customer-grid">
                    <div class="info-card">
                        <div class="info-label">Customer Name</div>
                        <div class="info-value">{{ $shipping['first_name'] ?? ($order->first_name ?? 'N/A') }}
                            {{ $shipping['last_name'] ?? ($order->last_name ?? '') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Email Address</div>
                        <div class="info-value">{{ $shipping['email'] ?? ($order->email ?? 'N/A') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Phone Number</div>
                        <div class="info-value">{{ $shipping['phone'] ?? ($order->phone ?? 'N/A') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Shipping Address</div>
                        <div class="info-value">
                            {{ $shipping['address_1'] ?? ($order->address_1 ?? 'N/A') }}<br>
                            {{ $shipping['city'] ?? ($order->city ?? '') }},
                            {{ $shipping['state'] ?? ($order->state ?? '') }}
                            {{ $shipping['post_code'] ?? ($order->post_code ?? '') }}<br>
                            {{ $shipping['country'] ?? ($order->country ?? 'N/A') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-section">
                <h3 class="action-title">What's Next?</h3>
                <p class="action-subtitle">Take action on your new order to provide excellent customer service</p>
                <div class="btn-group">

                    <a href="{{ url('/vendor') }}" class="btn btn-primary">
                        <span>🏪</span> View in Dashboard
                    </a>

                    <a href="{{ url('/vendor/orders' . $childOrder->id) }}" class="btn btn-success">
                        <span>⚙️</span> Process Order
                    </a>

                    <a href="{{ url('/vendor/products') }}" class="btn btn-info">
                        <span>📦</span> Check Inventory
                    </a>

                </div>
            </div>

            <!-- Business Tips -->
            <div class="tips-section">
                <h4 class="tips-title">
                    <span style="margin-right: 10px;">💡</span>
                    Tips for Success
                </h4>
                <ul class="tips-list">
                    <li>Process orders within 24 hours to maintain high customer satisfaction</li>
                    <li>Update order status regularly to keep customers informed</li>
                    <li>Ensure product quality and accurate descriptions to avoid returns</li>
                    <li>Respond to customer inquiries promptly to build trust</li>
                    <li>Consider offering fast shipping to increase your store rating</li>
                </ul>
            </div>

            <!-- Important Notes -->
            @if (isset($order->notes) && $order->notes)
                <div
                    style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 12px; padding: 25px; margin-bottom: 30px;">
                    <h4 style="color: #856404; margin-bottom: 15px; display: flex; align-items: center;">
                        <span style="margin-right: 10px;">📝</span> Customer Notes
                    </h4>
                    <p style="color: #856404; margin: 0; font-size: 14px; line-height: 1.5;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <h4 class="footer-title">Afrikart Vendor Portal</h4>
                <p class="footer-subtitle">Growing your business, one order at a time</p>
            </div>
            <div class="footer-links">
                <a href="{{ url('/vendor/dashboard') }}">Vendor Dashboard</a>
                <a href="{{ url('/vendor/orders') }}">Manage Orders</a>
                <a href="{{ url('/vendor/products') }}">My Products</a>
                {{-- <a href="{{ url('/vendor/earnings') }}">Earnings</a>
                <a href="{{ url('/vendor/support') }}">Support</a> --}}
            </div>
            <div class="footer-contact">
                <p>Questions? Contact our vendor support team at vendor-support@Afrikart.com</p>
                <p>© {{ date('Y') }} Afrikart E-commerce. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
