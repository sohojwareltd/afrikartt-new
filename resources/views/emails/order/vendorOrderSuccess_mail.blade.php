<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order for Your Store - {{ $order->id ?? 'Order Notification' }}</title>
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
                        <td style="text-align: center; padding-bottom: 15px;">
                            <div
                                style="background: rgba(255, 255, 255, 0.2); border: 2px solid rgba(255, 255, 255, 0.3); border-radius: 50px; padding: 8px 20px; font-size: 14px; font-weight: 600; display: inline-block;">
                                🏪 Vendor Portal
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <h1 style="font-size: 24px; font-weight: 700; margin-bottom: 8px; color: white;">🎉
                                Congratulations!</h1>
                            <p style="font-size: 16px; margin: 0; opacity: 0.9;">
                                You've received a new order for your products
                            </p>
                            <div
                                style="background: #28a745; color: white; padding: 12px 20px; border-radius: 25px; font-size: 16px; font-weight: 700; display: inline-block; margin-top: 15px;">
                                💰 You've earned ${{ number_format($childOrder->vendor_total ?? 0, 2) }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>




        <!-- Your Products Sold -->
        <tr>
            <td style="padding: 20px 30px 20px 30px; ">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <h3
                                style="font-size: 18px; font-weight: 700; color: #333; margin: 0; display: flex; align-items: center;">
                                <span style="margin-right: 10px;">🛒</span> Your Products in This Order
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background: #f8f9fa; border-radius: 8px; padding: 15px;">
                                @foreach ($childOrder->products as $product)
                                    @php
                                        $variation = json_decode($product->pivot->variation, true);
                                    @endphp
                                    <tr>
                                        <td style="padding: 15px 0; border-bottom: 1px solid #e9ecef;">
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td width="50" valign="top" style="padding-right: 12px;">
                                                        @if (isset($product->image) && $product->image)
                                                            <img src="{{ Storage::url($product->image) }}"
                                                                alt="{{ $product->name ?? 'Product' }}"
                                                                style="width: 50px; height: 50px; border-radius: 6px; object-fit: cover;">
                                                        @else
                                                            <div
                                                                style="width: 50px; height: 50px; background: #e9ecef; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 16px; color: #6c757d;">
                                                                📦</div>
                                                        @endif
                                                    </td>
                                                    <td valign="top">
                                                        <div
                                                            style="font-size: 15px; font-weight: 600; color: #333; margin-bottom: 5px;">
                                                            {{ $product->name ?? 'Product Name' }}</div>
                                                        @if (isset($product->sku) && $product->sku)
                                                            <div
                                                                style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                                SKU: {{ $product->sku }}</div>
                                                        @endif
                                                        @if ($variation && isset($variation['sku']))
                                                            <div
                                                                style="font-size: 12px; color: #666; margin-bottom: 5px;">
                                                                Variation: {{ $variation['sku'] }}
                                                            </div>
                                                        @endif
                                                        <div
                                                            style="background: #DE991B; color: white; padding: 4px 10px; border-radius: 12px; font-size: 12px; font-weight: 600; display: inline-block;">
                                                            Qty: {{ $product->pivot->quantity ?? 1 }}
                                                        </div>
                                                    </td>
                                                    <td width="80" valign="top" style="text-align: right;">
                                                        <div style="font-size: 15px; font-weight: 700; color: #28a745;">
                                                            ${{ number_format($product->pivot->total_price, 2) }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
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
                                style="background: #e3f2fd; border-radius: 8px; padding: 15px;">
                                @php
                                    $shipping = $childOrder->shipping;
                                    if (is_string($shipping)) {
                                        $shipping = json_decode($shipping, true);
                                    } elseif (!is_array($shipping)) {
                                        $shipping = [];
                                    }
                                @endphp
                                {{-- @dd($shipping) --}}
                                <tr>
                                    <td style="padding: 8px 0; font-size: 14px; color: #666;">Customer Name</td>
                                    <td
                                        style="padding: 8px 0; text-align: right; font-size: 14px; font-weight: 600; color: #333;">
                                        {{ $shipping['firstName'] ?? 'N/A' }}
                                        {{ $shipping['lastName'] ?? '' }}
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
                                        {{ $shipping['city'] ?? '' }},
                                        {{ $shipping['state'] ?? '' }}<br>
                                        {{ $shipping['post_code'] ?? '' }},
                                        {{ $shipping['country_code'] ?? 'N/A' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Action Buttons -->
        <tr>
            <td style="padding: 0 30px 20px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #f8f9fa; border-radius: 8px; padding: 20px;">
                    <tr>
                        <td style="text-align: center;">
                            <h3 style="font-size: 16px; font-weight: 700; color: #333; margin-bottom: 15px;">What's
                                Next?</h3>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="text-align: center; padding: 5px;">
                                        <a href="{{ url('/vendor') }}"
                                            style="background: #DE991B; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block; margin: 5px;">
                                            🏪 View in Dashboard
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: center; padding: 5px;">
                                        <a href="{{ url('/vendor/orders/' . $childOrder->id) }}"
                                            style="background: #28a745; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; display: inline-block; margin: 5px;">
                                            ⚙️ Process Order
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>



        <!-- Customer Notes -->
        @if (isset($order->notes) && $order->notes)
            <tr>
                <td style="padding: 0 30px 20px 30px;">
                    <table width="100%" cellpadding="0" cellspacing="0" border="0"
                        style="background: #fff3cd; border-radius: 8px; padding: 15px;">
                        <tr>
                            <td>
                                <h4 style="color: #856404; margin-bottom: 8px; display: flex; align-items: center;">
                                    <span style="margin-right: 8px;">📝</span> Customer Notes
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
                            <h4 style="font-size: 16px; font-weight: 700; margin: 0 0 5px 0;">Royalit Vendor Portal
                            </h4>
                            <p style="font-size: 12px; opacity: 0.9; margin: 0;">Growing your business, one order at a
                                time</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 15px;">
                            <a href="{{ url('/vendor/dashboard') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">Vendor
                                Dashboard</a>
                            <a href="{{ url('/vendor/orders') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">Manage
                                Orders</a>
                            <a href="{{ url('/vendor/products') }}"
                                style="color: #ecf0f1; text-decoration: none; font-size: 12px; margin: 0 8px;">My
                                Products</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size: 11px; color: #bdc3c7; line-height: 1.5; margin: 0;">
                                Questions? Contact our vendor support team<br>
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
