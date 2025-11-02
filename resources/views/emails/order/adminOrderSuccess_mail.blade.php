<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Order Received - {{ $order->order_id ?? 'Order Notification' }}</title>
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
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
            height: auto;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
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

        /* Notification Badge */
        .notification-badge {
            background: #ff6b35;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
            margin-top: 15px;
            position: relative;
            z-index: 2;
        }

        /* Main Content */
        .email-body {
            padding: 40px 30px;
        }

        .alert-section {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert-icon {
            font-size: 48px;
            color: #856404;
            margin-bottom: 15px;
        }

        .alert-title {
            font-size: 22px;
            font-weight: 700;
            color: #856404;
            margin-bottom: 8px;
        }

        .alert-message {
            color: #856404;
            font-size: 16px;
        }

        /* Order Summary Section */
        .order-summary {
            background: #f8f9fa;
            border-radius: 8px;
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

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .price-value {
            color: #DE991B;
            font-size: 18px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        /* Customer Information */
        .customer-section {
            background: #e8f4f5;
            border-radius: 8px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .customer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Order Items Table */
        .items-section {
            margin-bottom: 30px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .items-table th {
            background: #DE991B;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: top;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 6px;
            object-fit: cover;
            margin-right: 12px;
        }

        .product-details h6 {
            margin: 0 0 4px 0;
            font-weight: 600;
            font-size: 14px;
        }

        .product-details p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }

        .quantity-badge {
            background: #e9ecef;
            color: #495057;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        /* Action Buttons */
        .action-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
        }

        .action-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #DE991B;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(1, 148, 154, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #333;
        }

        /* Footer */
        .email-footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .footer-content {
            margin-bottom: 20px;
        }

        .footer-links {
            margin-bottom: 20px;
        }

        .footer-links a {
            color: #ecf0f1;
            text-decoration: none;
            margin: 0 10px;
            font-size: 14px;
        }

        .footer-contact {
            font-size: 12px;
            color: #bdc3c7;
            line-height: 1.5;
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }

            .email-header,
            .email-body {
                padding: 20px;
            }

            .header-title {
                font-size: 24px;
            }

            .order-info-grid,
            .customer-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }

            .items-table {
                font-size: 12px;
            }

            .items-table th,
            .items-table td {
                padding: 10px 8px;
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
                    <div style="font-size: 24px; font-weight: bold; color: white;">Royalit</div>
                @endif
            </div>
            <h1 class="header-title">🛍️ New Order Received!</h1>
            <p class="header-subtitle">A customer has just placed a new order on your store</p>
            <div class="notification-badge">Order #{{ $order->order_id ?? 'N/A' }}</div>
        </div>

        <!-- Main Content -->
        <div class="email-body">
            <!-- Alert Section -->
            <div class="alert-section">
                <div class="alert-icon">🔔</div>
                <h2 class="alert-title">Action Required</h2>
                <p class="alert-message">A new order has been placed and requires your attention. Please review and
                    process the order promptly.</p>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="section-title">
                    <span class="section-icon">📋</span>
                    Order Summary
                </h3>
                <div class="order-info-grid">
                    <div class="info-card">
                        <div class="info-label">Order ID</div>
                        <div class="info-value">#{{ $order->order_id ?? 'N/A' }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Date</div>
                        <div class="info-value">
                            {{ isset($order->created_at) ? $order->created_at->format('M d, Y - H:i A') : date('M d, Y - H:i A') }}
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Order Status</div>
                        <div class="info-value">
                            <span
                                class="status-badge status-pending">{{ $order->status === 1 ? 'Paid' : 'Pending' }}</span>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Total Amount</div>
                        <div class="info-value price-value">${{ number_format($order->total ?? 0, 2) }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Payment Method</div>
                        <div class="info-value">{{ ucfirst($order->payment_method ?? 'Cash') }}</div>
                    </div>
                    <div class="info-card">
                        <div class="info-label">Payment Status</div>
                        <div class="info-value">
                            <span
                                class="status-badge {{ ($order->payment_status ?? 'pending') === 'paid' ? 'status-confirmed' : 'status-pending' }}">
                                {{ ucfirst($order->payment_status == 1 ? 'Paid' : 'Pending') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-section">
                <h3 class="section-title">
                    <span class="section-icon">👤</span>
                    Customer Information
                </h3>
                @php
                    $shipping = $order->shipping;
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
                            {{ $shipping['post_code'] ?? ($order->post_code ?? '') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            @if (isset($order->childs) && count($order->childs) > 0)
                <div class="items-section">
                    <h3 class="section-title">
                        <span class="section-icon">📦</span>
                        Order Items ({{ count($order->childs) }} items)
                    </h3>
                    <table class="items-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->childs as $item)
                                <tr>
                                    <td>
                                        <div class="product-info">
                                            @if (isset($item->product) && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                                    alt="{{ $item->product->name ?? 'Product' }}"
                                                    class="product-image">
                                            @else
                                                <div
                                                    style="width: 50px; height: 50px; background: #f1f3f4; border-radius: 6px; margin-right: 12px; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #6c757d;">
                                                    No Image
                                                </div>
                                            @endif
                                            <div class="product-details">
                                                <h6>{{ $item->product->name ?? ($item->name ?? 'Product Name') }}</h6>
                                                @if (isset($item->product) && $item->product->sku)
                                                    <p>SKU: {{ $item->product->sku }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="quantity-badge">{{ $item->quantity ?? 1 }}</span>
                                    </td>

                                    <td>${{ number_format($item->price ?? 0, 2) }}</td>
                                    <td class="price-value">
                                        ${{ number_format(($item->price ?? 0) * ($item->quantity ?? 1), 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-section">
                <h3 class="action-title">Quick Actions</h3>
                <div class="btn-group">

                    <a href="{{ url('/admin') }}" class="btn btn-primary">
                        <span>🏪</span> View in Dashboard
                    </a>


                    <a href="{{ url('/admin/orders/') }}" class="btn btn-primary">
                        <span>⚙️</span> Manage Order
                    </a>


                    <a href="{{ url('/admin/customers/') }}" class="btn btn-secondary">
                        <span>📧</span> Contact Customer
                    </a>

                </div>
            </div>

            <!-- Order Notes (if any) -->
            @if (isset($order->notes) && $order->notes)
                <div
                    style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                    <h4 style="color: #856404; margin-bottom: 10px;">📝 Order Notes</h4>
                    <p style="color: #856404; margin: 0;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <div class="footer-content">
                <h4>Royalit E-commerce Admin</h4>
                <p>Your trusted e-commerce platform</p>
            </div>
            <div class="footer-links">
                <a href="{{ url('/admin') }}">Admin Dashboard</a>
                <a href="{{ url('/admin/orders') }}">Manage Orders</a>
                <a href="{{ url('/admin/settings') }}">Settings</a>
            </div>
            <div class="footer-contact">
                <p>This is an automated notification. Please do not reply to this email.</p>
                <p>© {{ date('Y') }} Royalit E-commerce. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
