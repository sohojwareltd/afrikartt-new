<div class="d-flex justify-content-end mb-4 no-print">
    <button onclick="printDiv('printableArea')" class="btn" style="background: var(--accent-color); color: #fff;">
        <i class="fas fa-print mr-2"></i> Print Invoice
    </button>
</div>

<div id="printableArea">
    <div class="invoice-container">
        <div class="invoice-header">
            <div class="logo">
                <img src="{{ Settings::setting('site_logo') }}" alt="Logo"
                    style="max-width: 150px; max-height: 50px;">
            </div>
            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p>#{{ $order->id }}</p>
                {{-- <span class="status-badge status-paid">Paid</span> --}}
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
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Payment Status:</strong> {{ $order->payment_status == 1 ? 'Paid' : 'Unpaid' }}</p>
                {{-- <p><strong>Transaction ID:</strong> {{ $order->transaction_id }}</p> --}}
            </div>
        </div>

        @php
            $orderSubtotal = 0;
            $orderShippingTotal = 0;
        @endphp

        @if ($order->childs && $order->childs->count() > 0)
            <!-- Loop through each child order for items grouped by shop -->
            @foreach ($order->childs as $childIndex => $childOrder)
                @if ($childOrder->products && $childOrder->products->count() > 0)
                    <!-- Shop Header -->
                    <div class="shop-header"
                        style="background-color: #f8f9fa; padding: 15px; margin: 20px 0 10px 0; border-left: 4px solid #007bff;">
                        <h4 style="margin: 0; color: #2c3e50;">
                            <i class="fas fa-store mr-2"></i>Shop: {{ $childOrder->shop->name ?? 'N/A' }}
                        </h4>
                        @if ($childOrder->shop)
                            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 14px;">
                                {{ $childOrder->shop->city ?? '' }}, {{ $childOrder->shop->state ?? '' }}
                                @if ($childOrder->shop->phone)
                                    • Phone: {{ $childOrder->shop->phone }}
                                @endif
                            </p>
                        @endif
                    </div>

                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th class="text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $shopSubtotal = 0;
                            @endphp

                            @foreach ($childOrder->products as $product)
                                @php
                                    $lineTotal = $product->pivot->price * $product->pivot->quantity;
                                    $shopSubtotal += $lineTotal;
                                    $orderSubtotal += $lineTotal;
                                @endphp

                                <tr>
                                    <td>
                                        <strong>{{ $product->name }}</strong>
                                        <div style="font-size: 12px; color: #6c757d;">SKU: {{ $product->sku ?? 'N/A' }}
                                        </div>
                                    </td>
                                    <td>{{ Sohoj::price($product->pivot->price) }}</td>
                                    <td>{{ $product->pivot->quantity }}</td>
                                    <td class="text-right">{{ Sohoj::price($lineTotal) }}</td>
                                </tr>
                            @endforeach

                            <!-- Shop Subtotal -->
                            <tr style="background-color: #f8f9fa;">
                                <td colspan="3" class="text-right" style="font-weight: bold;">Shop Subtotal:</td>
                                <td class="text-right" style="font-weight: bold;">{{ Sohoj::price($shopSubtotal) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endforeach
        @else
            <!-- Fallback to original single order items if no child orders -->
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Qty</th>
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
                                <strong>{{ $product->name }}</strong>
                                <div style="font-size: 12px; color: #6c757d;">SKU: {{ $product->sku ?? 'N/A' }}</div>
                            </td>
                            <td>{{ Sohoj::price($product->pivot->price) }}</td>
                            <td>{{ $product->pivot->quantity }}</td>
                            <td class="text-right">{{ Sohoj::price($lineTotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Calculate shipping total from child orders if they exist -->
        @php
            if ($order->childs && $order->childs->count() > 0) {
                $orderShippingTotal = 0;
                foreach ($order->childs as $childOrder) {
                    $orderShippingTotal += $childOrder->shipping_total ?? 0;
                }
            } else {
                $orderShippingTotal = $order->shipping_total;
            }
        @endphp

        <div class="total-section mt-3">
            <div class="total-row">
                <span>Subtotal:</span>
                <span>{{ Sohoj::price($orderSubtotal) }}</span>
            </div>
            <div class="total-row">
                <span>Shipping:</span>
                <span>{{ Sohoj::price($orderShippingTotal) }}</span>
            </div>
            <div class="total-row fw-bold">
                <span>Total:</span>
                <span>{{ Sohoj::price($orderSubtotal + $orderShippingTotal) }}</span>
            </div>
        </div>

        <div class="additional-info">
            <h5>Additional Information</h5>
            <p>Thank you for your purchase! If you have any questions about this invoice, please contact our
                customer service.</p>
            <p><strong>Transaction Number:</strong> {{ $order->transaction_id }}</p>
            <p class="text-center mt-3" style="font-size: 18px;">
                <strong>Total Paid:</strong>
                <span style="font-size: 24px; color: #2c3e50;">{{ Sohoj::price($order->total) }}</span>
                USD
            </p>
        </div>

        <div class="footer">
            <p>Royalit E-commerce | New York, USA | {{ Settings::setting('site_email') }}</p>
            <p>This is a computer generated invoice. No signature required.</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
