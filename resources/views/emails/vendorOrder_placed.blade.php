<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Received - Royalit</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="max-width: 600px; margin: 0 auto; background: #ffffff;">
        <!-- Header -->
        <tr>
            <td style="background: #F5A623; color: #2C2C2C; padding: 30px; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding-bottom: 20px;">
                            <img src="{{ Settings::setting('site_logo') }}" alt="Royalit"
                                style="height: 40px; display: block; margin: 0 auto;">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <h1 style="font-size: 28px; font-weight: 700; margin-bottom: 15px; color: #2C2C2C;">New
                                Order Received</h1>
                            <p style="font-size: 16px; color: #6d4c00; margin: 0;">
                                You have received a new order for your shop.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Order Summary -->
        <tr>
            <td style="padding: 25px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #f7f7f7; border-radius: 8px; padding: 20px;">
                    <tr>
                        <td width="50%" valign="top" style="padding: 0 10px;">
                            <h3 style="font-size: 16px; color: #222; margin-bottom: 10px;">Order Details</h3>
                            <div style="font-size: 14px; color: #444; margin-bottom: 5px;">
                                <strong>Order #{{ $childOrder->id }}</strong>
                            </div>
                            <div style="font-size: 13px; color: #888; margin-bottom: 5px;">
                                Date: {{ $childOrder->created_at->format('M d, Y') }}
                            </div>
                            <div style="font-size: 14px; color: #222; margin-bottom: 5px;">
                                Status: <span
                                    style="color: #10b981; font-weight: 600;">{{ ucfirst($childOrder->status == 0 ? 'pending' : ($childOrder->status == 1 ? 'paid' : ($childOrder->status == 2 ? 'on its way' : ($childOrder->status == 3 ? 'cancelled' : 'delivered')))) }}</span>
                            </div>
                        </td>
                        <td width="50%" valign="top" style="padding: 0 10px;">
                            <h3 style="font-size: 16px; color: #222; margin-bottom: 10px;">Customer Details</h3>
                            @php
                                $shipping = $childOrder->shipping;
                                if (is_string($shipping)) {
                                    $shipping = json_decode($shipping, true);
                                } elseif (!is_array($shipping)) {
                                    $shipping = [];
                                }
                            @endphp
                            <div style="font-size: 14px; color: #222; font-weight: 600;">
                                {{ $shipping['first_name'] ?? ($order->first_name ?? 'N/A') }}
                                {{ $shipping['last_name'] ?? ($order->last_name ?? '') }}
                            </div>
                            <div style="font-size: 13px; color: #444;">
                                {{ $shipping['address'] ?? 'N/A' }}
                            </div>
                            <div style="font-size: 13px; color: #444;">
                                {{ $shipping['city'] ?? '' }}{{ !empty($shipping['city']) && !empty($shipping['state']) ? ', ' : '' }}{{ $shipping['state'] ?? '' }}
                                {{ $shipping['zip'] ?? '' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Order Item -->
        <tr>
            <td style="padding: 0 30px 25px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #fafafa; border-radius: 8px; padding: 20px;">
                    <tr>
                        <td>
                            <h2 style="font-size: 18px; color: #2C2C2C; margin-bottom: 15px;">Order Item</h2>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td width="60" valign="top" style="padding-right: 15px;">
                                        @if ($childOrder->product && $childOrder->product->image)
                                            <img src="{{ Storage::url($childOrder->product->image) }}"
                                                alt="{{ $childOrder->product->name }}"
                                                style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                        @else
                                            <div
                                                style="width: 60px; height: 60px; border-radius: 8px; background: #e0e0e0; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px; font-weight: 600;">
                                                No Image</div>
                                        @endif
                                    </td>
                                    <td valign="top">
                                        <div
                                            style="font-size: 16px; font-weight: 700; color: #2C2C2C; margin-bottom: 5px;">
                                            {{ $childOrder->product->name ?? 'Product' }}</div>
                                        <div style="margin-bottom: 8px;">
                                            <span
                                                style="background: #2C2C2C; color: #fff; padding: 3px 8px; border-radius: 12px; font-size: 11px; font-weight: 600; display: inline-block; margin-right: 5px;">Qty:
                                                {{ $childOrder->quantity ?? 1 }}</span>
                                        </div>
                                        <div style="font-size: 16px; font-weight: 800; color: #F5A623;">
                                            ${{ number_format($childOrder->product_price, 2) }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Financial Breakdown -->
        <tr>
            <td style="padding: 0 30px 25px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #222;">Product Total</td>
                        <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #222;">
                            {{ Sohoj::price($childOrder->vendor_total) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #10b981;">Platform Fee</td>
                        <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #10b981;">
                            -{{ Sohoj::price($childOrder->platform_fee) }}</td>
                    </tr>
                    @if (session()->has('discount'))
                        <tr>
                            <td style="padding: 8px 0; font-size: 14px; color: #10b981;">Discount</td>
                            <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #10b981;">
                                -{{ Sohoj::price($childOrder->discount) }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px 0; font-size: 14px; color: #222;">Shipping</td>
                        <td style="padding: 8px 0; text-align: right; font-size: 14px; color: #222;">
                            {{ Sohoj::price($childOrder->shipping_total) }}</td>
                    </tr>
                    <tr>
                        <td
                            style="padding: 12px 0; font-weight: bold; border-top: 2px solid #222; font-size: 16px; color: #222;">
                            Your Earnings</td>
                        <td
                            style="padding: 12px 0; text-align: right; font-weight: bold; border-top: 2px solid #222; font-size: 16px; color: #F5A623;">
                            {{ Sohoj::price($childOrder->vendor_total - $childOrder->platform_fee) }}</td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Action Required -->
        <tr>
            <td style="padding: 0 30px 25px 30px;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #FFF8E1; border-radius: 8px; padding: 20px;">
                    <tr>
                        <td>
                            <h3 style="font-size: 16px; color: #2C2C2C; margin-bottom: 10px;">Action Required</h3>
                            <p style="font-size: 14px; color: #666; margin: 0; line-height: 1.5;">
                                Please process this order and update the status in your vendor dashboard. For any
                                issues, contact support at
                                <a href="mailto:{{ Settings::setting('site_email') }}"
                                    style="color: #F5A623; text-decoration: none; font-weight: 600;">{{ Settings::setting('site_email') }}</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background: #0d5960; color: #ffffff; padding: 20px; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="font-size: 14px; color: #ffffff; padding-bottom: 8px;">
                            &copy; {{ date('Y') }} Royalit. All rights reserved.
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px; color: #ffffff;">
                            {{ Settings::setting('site_address', 'Royalit HQ, Accra, Ghana 00233') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
