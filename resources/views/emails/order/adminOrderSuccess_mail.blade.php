<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received - {{ $order->id ?? 'Order Notification' }}</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333333; background-color: #f5f7fa;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <!-- Header -->
        <tr>
            <td style="background: #DE991B; color: white; padding: 30px; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding-bottom: 20px;">
                            <img src="{{ Settings::setting('site_logo') }}" alt=" Royalit Logo"
                                style="height: 40px; display: block; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: white;">🛍️ New
                                Order Received!</h1>
                            <p style="font-size: 16px; margin: 0; opacity: 0.9;">
                                A customer has just placed a new order on your store
                            </p>
                            <div
                                style="background: #ff6b35; color: white; padding: 8px 16px; border-radius: 20px; font-size: 14px; font-weight: 600; display: inline-block; margin-top: 15px;">
                                Order #{{ $order->id ?? 'N/A' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Alert Section -->
        <tr>
            <td style="padding: 25px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #fff3cd; border-radius: 8px; padding: 20px;">
                    <tr>
                        <td style="text-align: center;">
                            <div style="font-size: 40px; margin-bottom: 10px;">🔔</div>
                            <h2 style="font-size: 18px; font-weight: 700; color: #856404; margin-bottom: 8px;">Action
                                Required</h2>
                            <p style="color: #856404; font-size: 14px; line-height: 1.5; margin: 0;">
                                A new order has been placed and requires your attention. Please review and process the
                                order promptly.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Order Summary -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <h3
                                style="font-size: 18px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center;">
                                <span style="margin-right: 10px;">📋</span> Order Summary
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background: #f8f9fa; border-radius: 8px; padding: 15px;">
                                <tr>
                                    <td width="50%" style="padding: 8px 0; font-size: 14px; color: #666;">Order ID
                                    </td>
                                    <td width="50%"
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        #{{ $order->id ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Order Date</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ isset($order->created_at) ? $order->created_at->format('M d, Y - H:i A') : date('M d, Y - H:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Order Status</td>
                                    <td style="padding: 8px 0; text-align: right;">
                                        <span
                                            style="background: #fff3cd; color: #856404; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                            {{ $order->status === 1 ? 'Paid' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Payment Method</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ ucfirst($order->payment_method ?? 'Cash') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Payment Status</td>
                                    <td style="padding: 8px 0; text-align: right;">
                                        <span
                                            style="background: {{ ($order->payment_status ?? 'pending') === 'paid' ? '#d4edda' : '#fff3cd' }}; color: {{ ($order->payment_status ?? 'pending') === 'paid' ? '#155724' : '#856404' }}; padding: 6px 12px; border-radius: 15px; font-size: 12px; font-weight: 600;">
                                            {{ ucfirst($order->payment_status == 1 ? 'Paid' : 'Pending') }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 12px 0; font-size: 16px; font-weight: 700; color: #333; border-top: 2px solid #DE991B;">
                                        Total Amount</td>
                                    <td
                                        style="padding: 12px 0; text-align: right; font-size: 16px; font-weight: 700; color: #DE991B; border-top: 2px solid #DE991B;">
                                        ${{ number_format($order->total ?? 0, 2) }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Customer Information -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <h3
                                style="font-size: 18px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center;">
                                <span style="margin-right: 10px;">👤</span> Customer Information
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background: #e8f4f5; border-radius: 8px; padding: 15px;">
                                @php
                                    $shipping = $order->shipping;
                                    if (is_string($shipping)) {
                                        $shipping = json_decode($shipping, true);
                                    } elseif (!is_array($shipping)) {
                                        $shipping = [];
                                    }
                                @endphp
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Customer Name</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ $shipping['firstName'] ?? 'N/A' }} {{ $shipping['lastName'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Email Address</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ $shipping['email'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Phone Number</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ $shipping['phone'] ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666; vertical-align: top;">
                                        Shipping Address</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ $shipping['address_line'] ?? 'N/A' }}<br>
                                        {{ $shipping['city'] ?? 'N/A' }}, {{ $shipping['state_code'] ?? '' }}
                                        {{ $shipping['post_code'] ?? '' }}<br>
                                        {{ $shipping['country_code'] ?? 'N/A' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>

        @if (isset($order->childs) && count($order->childs) > 0)
            <tr>
                <td style="padding: 0 30px 20px 30px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="padding-bottom: 15px;">
                                <h3
                                    style="font-size: 18px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center;">
                                    <span style="margin-right: 10px;">🛒</span> Order Items
                                    ({{ $order->products->sum('pivot.quantity') }} items)
                                </h3>
                            </td>
                        </tr>

                        @foreach ($order->childs as $child)
                            <tr>
                                <td style="padding-bottom: 15px;">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                        style="border: 1px solid #e9ecef; border-radius: 10px; overflow: hidden; background: #fff;">
                                        <tr style="background: #f1f3f5;">
                                            <td style="padding: 15px;">
                                                <h4 style="margin: 0; font-size: 16px; font-weight: 700; color: #333;">
                                                    {{ $child->shop->name ?? 'Shop' }}
                                                </h4>
                                                <p style="font-size: 12px; color: #6c757d; margin: 3px 0 0;">
                                                    {{ $child->shop->city ?? '' }}, {{ $child->shop->state ?? '' }}
                                                    @if ($child->shop->email)
                                                        • Email: {{ $child->shop->email }}
                                                    @endif
                                                </p>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td style="padding: 15px;">
                                                <table width="100%" cellpadding="0" cellspacing="0"
                                                    border="0">
                                                    @foreach ($child->products as $item)
                                                        @php
                                                            $variation = json_decode($item->pivot->variation, true);
                                                        @endphp
                                                        <tr style="border-bottom: 1px solid #e9ecef;">
                                                            <td width="60" valign="top"
                                                                style="padding-right: 15px;">
                                                                @if (isset($item->image) && $item->image)
                                                                    <img src="{{ Storage::url($item->image) }}"
                                                                        alt="{{ $item->name ?? 'Product' }}"
                                                                        style="width: 60px; height: 60px; border-radius: 6px; object-fit: cover;">
                                                                @else
                                                                    <div
                                                                        style="width: 60px; height: 60px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 20px; color: #6c757d;">
                                                                        📦
                                                                    </div>
                                                                @endif
                                                            </td>

                                                            <td valign="top">
                                                                <div
                                                                    style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 5px;">
                                                                    {{ $item->name ?? 'Product Name' }}
                                                                </div>
                                                                @if (isset($item->sku) && $item->sku)
                                                                    <div
                                                                        style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                                        SKU: {{ $item->sku }}
                                                                    </div>
                                                                @endif
                                                                @if ($variation && isset($variation['sku']))
                                                                    <div
                                                                        style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                                        Variation: {{ $variation['sku'] }}
                                                                    </div>
                                                                @endif
                                                                <div style="font-size: 13px; color: #666;">
                                                                    Qty: {{ $item->pivot->quantity ?? 1 }}
                                                                </div>
                                                            </td>

                                                            <td width="80" valign="top"
                                                                style="text-align: right; font-size: 15px; font-weight: 600; color: #333;">
                                                                ${{ number_format($item->pivot->total_price, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </td>
            </tr>
        @endif

        <!-- Order Notes -->
        @if (isset($order->notes) && $order->notes)
            <tr>
                <td style="padding: 0 30px 20px 30px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                        style="background: #fff3cd; border-radius: 8px; padding: 15px;">
                        <tr>
                            <td>
                                <h4 style="color: #856404; margin-bottom: 8px; display: flex; align-items: center;">
                                    <span style="margin-right: 8px;">📝</span> Order Notes
                                </h4>
                                <p style="color: #856404; margin: 0; font-size: 14px; line-height: 1.5;">
                                    {{ $order->notes }}</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif

        <!-- Footer -->
        <tr>
            <td style="background: #2c3e50; color: white; padding: 20px; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <h4 style="font-size: 16px; font-weight: 700; margin: 0 0 5px 0;">Royalit E-commerce Admin
                            </h4>
                            <p style="font-size: 12px; opacity: 0.9; margin: 0;">Your trusted e-commerce platform</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <a href="{{ url('/admin') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">Admin
                                Dashboard</a>
                            <a href="{{ url('/admin/orders') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">Manage
                                Orders</a>
                            <a href="{{ url('/admin/settings') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">Settings</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 11px; color: #bdc3c7; line-height: 1.5; margin: 0;">
                                This is an automated notification. Please do not reply to this email.<br>
                                © {{ date('Y') }} Royalit E-commerce. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
