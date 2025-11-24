<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification - Royalit</title>
</head>

<body
    style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif; line-height: 1.6; color: #333; background-color: #f5f5f5; padding: 20px 0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="max-width: 600px; margin: 0 auto; background: #ffffff; overflow: hidden;">
        <!-- Header -->
        <tr>
            <td style="background: #F5A623; color: #2C2C2C; padding: 40px 30px; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding-bottom: 30px;">
                            <div
                                style="display: inline-block; background: #fff; color: #F5A623; border-radius: 4px; padding: 8px 12px;">
                                <img src="{{ Settings::setting('site_logo') }}" alt="Logo"
                                    style="height: 40px; display: block;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;">
                            <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 20px; color: #2C2C2C;">New
                                Order Received</h1>
                            <p
                                style="font-size: 16px; color: #6d4c00; margin-bottom: 25px; line-height: 1.4; max-width: 400px; margin-left: auto; margin-right: auto;">
                                A new order has been placed and requires your attention.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 40px 30px; background: #ffffff;">
                <!-- Summary Section -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #f7f7f7; border-radius: 8px; margin-bottom: 32px;">
                    <tr>
                        <td style="padding: 24px 16px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td width="50%" valign="top" style="padding: 0 8px;">
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
                                    </td>
                                    <td width="50%" valign="top" style="padding: 0 8px;">
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
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Items Section -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #ffffff; border-radius: 12px; margin-bottom: 40px; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08); border: 1px solid #f0f0f0;">
                    <tr>
                        <td style="padding: 30px;">
                            <h2
                                style="font-size: 28px; font-weight: 700; color: #2C2C2C; text-align: center; margin-bottom: 8px; letter-spacing: -0.5px;">
                                Order Items</h2>
                            <div
                                style="text-align: center; font-size: 15px; color: #888; margin-bottom: 35px; font-weight: 500;">
                                Order number: #{{ $childOrder->id }}</div>

                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="background: #fafafa; border-radius: 10px; padding: 25px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 25px 0;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="65" valign="top" style="padding-right: 25px;">
                                                    @if ($childOrder->product->image)
                                                        <img src="{{ Storage::url( $childOrder->product->image) }}"
                                                            alt="{{ $childOrder->product->name }}"
                                                            style="width: 65px; height: 65px; border-radius: 12px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">
                                                    @else
                                                        <div
                                                            style="width: 65px; height: 65px; border-radius: 12px; background: linear-gradient(135deg, #f0f0f0, #e0e0e0); display: flex; align-items: center; justify-content: center; color: #999; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                                                            No Image</div>
                                                    @endif
                                                </td>
                                                <td valign="top">
                                                    <div
                                                        style="font-size: 18px; font-weight: 700; color: #2C2C2C; margin-bottom: 8px; line-height: 1.3;">
                                                        {{ $childOrder->product->name }}</div>
                                                    <div style="margin-bottom: 12px;">
                                                        <span
                                                            style="background: #2C2C2C; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; display: inline-block; margin-right: 8px;">Qty:
                                                            {{ $childOrder->quantity ?? 1 }}</span>
                                                        <span
                                                            style="background: #10b981; color: #fff; padding: 4px 12px; border-radius: 15px; font-size: 12px; font-weight: 600; display: inline-block;">{{ $childOrder->shop->name ?? 'N/A' }}</span>
                                                    </div>
                                                    @if ($childOrder->variation)
                                                        <div
                                                            style="font-size: 14px; color: #777; margin-bottom: 12px; line-height: 1.4; background: #f0f8ff; padding: 6px 12px; border-radius: 15px; display: inline-block; border-left: 3px solid #F5A623;">
                                                            {{ $childOrder->variation }}</div>
                                                    @endif
                                                    <div
                                                        style="font-size: 20px; font-weight: 800; color: #F5A623; text-shadow: 0 1px 2px rgba(245, 166, 35, 0.2);">
                                                        ${{ number_format($childOrder->product_price, 2) }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Financial Breakdown -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-top: 30px; padding-top: 18px; border-top: 1px solid #eee;">
                                <tr>
                                    <td style="padding: 6px 0; font-size: 15px; color: #222;">Vendor Fee</td>
                                    <td style="padding: 6px 0; text-align: right; font-size: 15px; color: #222;">
                                        {{ Sohoj::price($childOrder->vendor_total) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 6px 0; font-size: 15px; color: #10b981;">Platform Fee</td>
                                    <td style="padding: 6px 0; text-align: right; font-size: 15px; color: #10b981;">
                                        {{ Sohoj::price($childOrder->platform_fee) }}</td>
                                </tr>
                                @if (session()->has('discount'))
                                    <tr>
                                        <td style="padding: 6px 0; font-size: 15px; color: #10b981;">Discount</td>
                                        <td style="padding: 6px 0; text-align: right; font-size: 15px; color: #10b981;">
                                            {{ Sohoj::price(Sohoj::discount()) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="padding: 6px 0; font-size: 15px; color: #222;">Shipping</td>
                                    <td style="padding: 6px 0; text-align: right; font-size: 15px; color: #222;">
                                        {{ Sohoj::price($childOrder->shipping_total) }}</td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 10px 0; font-weight: bold; border-top: 2px solid #222; font-size: 15px; color: #222;">
                                        Total</td>
                                    <td
                                        style="padding: 10px 0; text-align: right; font-weight: bold; border-top: 2px solid #222; font-size: 15px; color: #222;">
                                        {{ Sohoj::price($childOrder->total) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Admin Action Section -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #f8f9fa; border: 1px solid #eee; border-radius: 6px; padding: 20px; margin-bottom: 32px;">
                    <tr>
                        <td>
                            <h3 style="font-size: 18px; color: #2C2C2C; margin-bottom: 10px;">Admin Actions</h3>
                            <p style="font-size: 14px; color: #444; margin-bottom: 12px;">
                                This order requires processing. Please review the order details and update the status
                                accordingly.
                            </p>
                            <table cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-bottom: 8px;">
                                        <strong style="font-size: 14px; color: #222;">Order ID:</strong>
                                        <span style="font-size: 14px; color: #444;">#{{ $childOrder->id }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong style="font-size: 14px; color: #222;">Current Status:</strong>
                                        <span
                                            style="font-size: 14px; color: #10b981; font-weight: 600;">{{ ucfirst($childOrder->status == 0 ? 'pending' : ($childOrder->status == 1 ? 'paid' : ($childOrder->status == 2 ? 'on its way' : ($childOrder->status == 3 ? 'cancelled' : 'delivered')))) }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Business Section -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                    style="background: #FFF8E1; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                    <tr>
                        <td width="50" valign="top" style="padding-right: 20px;">
                            <div
                                style="width: 50px; height: 50px; background: #2C2C2C; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #ffffff; font-size: 20px;">
                                ✉️</div>
                        </td>
                        <td valign="top">
                            <h3 style="font-size: 18px; font-weight: 600; color: #2C2C2C; margin-bottom: 5px;">Order
                                Management</h3>
                            <p style="font-size: 14px; color: #666; line-height: 1.5; margin: 0;">
                                For any order-related queries or system issues, contact <a
                                    href="mailto:{{ Settings::setting('site_email') }}"
                                    style="color: #F5A623; text-decoration: none; font-weight: 600;">{{ Settings::setting('site_email') }}</a><br>
                                Please ensure timely processing and updates for all orders.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td
                style="background: #0d5960; color: #ffffff; padding: 24px 0; border-top: 1px solid #eee; text-align: center;">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="text-align: center; padding-bottom: 10px;">
                            <div
                                style="display: inline-block; background: #fff; color: #F5A623; border-radius: 4px; padding: 8px 12px;">
                                <img src="{{ Settings::setting('site_logo') }}" alt="Logo"
                                    style="height: 40px; display: block;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px; color: #ffffff; margin-bottom: 8px; padding-bottom: 8px;">
                            &copy; {{ date('Y') }} Royalit. All rights reserved.
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 13px; color: #ffffff; margin-bottom: 8px;">
                            {{ Settings::setting('site_address', 'Royalit HQ, Accra, Ghana 00233') }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
