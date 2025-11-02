<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .invoice-container {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .invoice-header img {
            max-width: 150px;
            max-height: 50px;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }

        .invoice-title p {
            margin: 4px 0 0;
            font-size: 14px;
            color: #666;
        }

        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-box {
            width: 48%;
        }

        .info-box h4 {
            margin-bottom: 5px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: #2c3e50;
        }

        .info-box p {
            margin: 3px 0;
            font-size: 13px;
        }

        .shop-info {
            margin-bottom: 20px;
        }

        .shop-info h5 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .shop-info p {
            margin: 2px 0;
            font-size: 13px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            font-size: 13px;
        }

        th {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            border-top: 2px solid #eee;
            padding-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 4px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .additional-info {
            margin-top: 20px;
            font-size: 13px;
        }

        .additional-info h5 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo">
                <img src="{{ public_path('storage/' . Settings::setting('site_logo')) }}" alt="Logo">
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p>#{{ $order->id }}</p>
            </div>
        </div>

        <div class="invoice-info">
            <div class="info-box">
                <h4>Bill To</h4>
                <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
                <p>{{ $order->email }}</p>
                <p>{{ $order->phone }}</p>
                <p>{{ $order->address }}</p>
                <p>{{ $order->city }}, {{ $order->state }} {{ $order->zip_code }}</p>
            </div>
            <div class="info-box">
                <h4>Invoice Details</h4>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Order Status:</strong>
                    {{ $order->status == 0 ? 'Pending' : ($order->status == 1 ? 'Paid' : ($order->status == 2 ? 'On the Way' : ($order->status == 3 ? 'Canceled' : 'Delivered'))) }}
                </p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'N/A' }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}</p>

            </div>
        </div>
        @php $orderSubtotal = 0; @endphp

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    @php
                        $lineTotal = $product->pivot->price * $product->pivot->quantity;
                        $orderSubtotal += $lineTotal;
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $product->name }}</strong><br>
                            {{ $product->pivot->quantity }} × {{ Sohoj::price($product->pivot->price) }}
                        </td>
                        <td>{{ Sohoj::price($product->pivot->price) }}</td>
                        <td class="text-right">{{ Sohoj::price($lineTotal) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2">Shipping Cost</td>
                    <td class="text-right">{{ Sohoj::price($order->shipping_total ?? 0) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>{{ Sohoj::price($order->subtotal) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>{{ Sohoj::price($order->shipping_total ?? 0) }}</span>
            </div>
            <div class="total-row fw-bold">
                <span>Total:</span>
                <span>{{ Sohoj::price($order->total) }}</span>
            </div>
        </div>

        <div class="additional-info">
            <h5>Additional Information</h5>
            <p>Thank you for your purchase! If you have any questions about this invoice, please contact our customer
                service.</p>

            <p class="text-center" style="font-size: 18px; margin-top: 10px;">
                <strong>Total Paid:</strong>
                <span style="font-size: 22px; color: #2c3e50;">{{ Sohoj::price($order->total) }}</span> USD
            </p>
        </div>

        <div class="footer">
            <p>Royalit E-commerce | New York, USA | Info@Royalit.com</p>
            <p>This is a computer generated invoice. No signature required.</p>
        </div>
    </div>
</body>

</html>
