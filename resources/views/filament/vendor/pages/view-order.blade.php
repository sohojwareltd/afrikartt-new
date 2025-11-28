
<x-filament::page>
    @push('styles')
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                        },
                        colors: {
                            primary: {
                                50: '#f0f9ff',
                                100: '#e0f2fe',
                                500: '#3b82f6',
                                600: '#2563eb',
                            },
                            secondary: {
                                500: '#8b5cf6',
                            }
                        }
                    }
                }
            }
        </script>
        <style>
            @media print {
                #body {
                    width: 210mm;
                    height: 297mm;
                }

                .no-print {
                    display: none !important;
                }

                .page-break {
                    page-break-after: always;
                }

                .shop-section {
                    page-break-inside: avoid;
                }
            }
        </style>
    @endpush
    <div id="body" class="bg-gray-50 font-sans text-gray-700">
        <div class="mx-auto my-8">
            <!-- Invoice Container -->
            <div class="bg-white  shadow-sm overflow-hidden p-6 mt-6 mb-5">
                <div id="printableArea">
                    <!-- Header with gradient -->
                    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-8 py-6">
                        <div class="flex justify-between items-center">
                            {{-- <div class="flex items-center space-x-3">
                                <!-- Replace with your logo -->
                                <div class="bg-white p-2 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <h1 class="text-2xl font-bold text-black">{{ $record->shop->name ?? 'N/A' }}</h1>
                            </div> --}}
                            <div class="text-right">
                                <h2 class="text-3xl font-bold text-white">INVOICE</h2>
                                <p class="text-primary-100 font-medium">
                                    #INV-{{ now()->format('Y') }}-{{ $record->id }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Meta -->
                    <div class="px-8 py-6 border-b border-gray-100">
                        <div class="px-8 py-6 flex justify-between">
                            <div class="text-start">
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice
                                        Date
                                    </h3>
                                    <p class="mt-1 text-sm font-medium">{{ $record->created_at->format('F j, Y') }}</p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Order
                                        Number
                                    </h3>
                                    <p class="mt-1 text-sm font-medium">
                                        #ORD-{{ now()->format('Y') }}-{{ $record->id }}
                                    </p>
                                </div>
                            </div>

                            <div class="text-start md:text-end">
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Order
                                        Status
                                    </h3>
                                    <p class="mt-1 text-sm font-medium">
                                        {{ $record->status == 0 ? 'Pending' : ($record->status == 1 ? 'Paid' : ($record->status == 2 ? 'On the Way' : ($record->status == 3 ? 'Canceled' : 'Delivered'))) }}
                                    </p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment
                                        Status
                                    </h3>
                                    <p class="mt-1 text-sm font-medium">
                                        {{ $record->payment_status == 0 ? 'Pending' : ($record->payment_status == 1 ? 'Paid' : 'Failed') }}
                                    </p>
                                </div>
                                <div>
                                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Delivery Option
                                    </h3>
                                    <p class="mt-1 text-sm font-medium">
                                        {{ $record->delivery_option == 'pickup_point' ? 'Pickup Point' : ($record->delivery_option == 'home_delivery' ? 'Home Delivery' : 'Failed') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- From/To -->
                    {{-- <div class="px-8 py-6 flex justify-between border-b border-gray-100">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">From</h3>
                            @if ($record->shop)
                                <p class="font-bold">{{ $record->shop->name ?? 'N/A' }}</p>
                                <p class="text-sm">
                                    {{ ($record->shop && $record->shop->state ? $record->shop->state : 'N/A') . '-' . ($record->shop && $record->shop->city ? $record->shop->city : 'N/A') . '-' . ($record->shop && $record->shop->post_code ? $record->shop->post_code : 'N/A') }}
                                </p>
                                <p class="text-sm mt-2">Phone: {{ $record->shop->phone ?? 'N/A' }}</p>
                                <p class="text-sm">Email: {{ $record->shop->email ?? 'N/A' }}</p>
                            @else
                                <p>Shop Information Not Available</p>
                            @endif
                        </div>


                    

                    </div> --}}

                    <!-- Items Table - Grouped by Shop/Child Orders -->
                    <div class="px-0 overflow-x-auto">
                        @if ($record->childs && $record->childs->count() > 0)
                            <!-- Loop through each child order for items -->
                            @foreach ($record->childs as $childIndex => $childOrder)
                                @if ($childOrder->products && $childOrder->products->count() > 0)
                                    <div
                                        class="shop-section mb-6 @if ($childIndex > 0) mt-8 pt-6 border-t border-gray-200 @endif">
                                        <!-- Shop Header -->
                                        <div class="bg-gray-50 px-6 py-3 mb-4">
                                            <h3 class="text-sm font-semibold text-gray-700">
                                                Shop: {{ $childOrder->shop->name ?? 'N/A' }}
                                            </h3>
                                            @if ($childOrder->shop)
                                                <p class="text-xs text-gray-500 mt-1">
                                                    {{ $childOrder->shop->city ?? '' }},
                                                    {{ $childOrder->shop->state ?? '' }}
                                                    @if ($childOrder->shop->email)
                                                        • Email: {{ $childOrder->shop->email }}
                                                    @endif
                                                </p>
                                            @endif
                                        </div>

                                        <table class="w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="ps-4 px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Item</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Price</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Qty</th>
                                                    <th scope="col"
                                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @php
                                                    $shopVendorSubtotal = 0;
                                                    $shopAdminSubtotal = 0;
                                                @endphp

                                                @foreach ($childOrder->products as $product)
                                                    @php
                                                        $quantity = $product->pivot->quantity;

                                                        // Calculate vendor price total
                                                        $vendorPrice = $childOrder->vendor_total;

                                                        $vendorTotal = $vendorPrice * $quantity;
                                                        $shopVendorSubtotal += $vendorTotal;

                                                        // Calculate admin price total
                                                        $adminPrice = $product->sale_price ?? ($product->price ?? 0);
                                                        $adminTotal = $adminPrice * $quantity;
                                                        $shopAdminSubtotal += $adminTotal;
                                                    @endphp
                                                    <tr>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                @if ($product?->image)
                                                                    <div
                                                                        class="flex-shrink-0 h-32 bg-gray-100 rounded-md overflow-hidden">
                                                                        <img src="{{ Storage::url($product->image) }}"
                                                                            alt="{{ $product->name }}"
                                                                            class="h-full w-full object-cover">
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md flex items-center justify-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                            class="h-6 w-6 text-gray-400" fill="none"
                                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                                            <path stroke-linecap="round"
                                                                                stroke-linejoin="round" stroke-width="2"
                                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                                <div class="ml-4">
                                                                    <div class="text-sm font-medium text-gray-900">
                                                                        {{ $product->name ?? 'N/A' }}
                                                                    </div>

                                                                    <div class="text-sm text-gray-500">SKU:
                                                                        {{ $product->sku ?? 'N/A' }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            @if (Auth::user()->role_id == 3)
                                                                ${{ number_format($vendorPrice, 2) }}
                                                            @elseif (Auth::user()->role_id == 1)
                                                                ${{ number_format($adminPrice, 2) }}
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                            {{ $quantity }}
                                                        </td>
                                                        <td
                                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                                            @if (Auth::user()->role_id == 3)
                                                                ${{ number_format($vendorTotal, 2) }}
                                                            @elseif (Auth::user()->role_id == 1)
                                                                ${{ number_format($adminTotal, 2) }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                                <!-- Shop Subtotal -->
                                                <tr class="bg-gray-50">
                                                    <td colspan="3"
                                                        class="px-6 py-3 text-right text-sm font-semibold text-gray-700">
                                                        Shop Subtotal:
                                                    </td>
                                                    <td
                                                        class="px-6 py-3 text-right text-sm font-semibold text-gray-900">
                                                        @if (Auth::user()->role_id == 3)
                                                            ${{ number_format($shopVendorSubtotal, 2) }}
                                                        @else
                                                            ${{ number_format($shopAdminSubtotal, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <!-- Fallback to original single order items if no child orders -->
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="ps-4 px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Item</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Price</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Qty</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $vendorSubtotal = 0;
                                        $adminSubtotal = 0;
                                    @endphp

                                    @foreach ($record->products as $product)
                                        @php
                                            $quantity = $product->pivot->quantity;

                                            // Calculate vendor price total
                                            $vendorPrice = $record->vendor_total;

                                            $vendorTotal = $vendorPrice * $quantity;
                                            $vendorSubtotal += $vendorTotal;

                                            // Calculate admin price total
                                            $adminPrice = $product->sale_price ?? ($product->price ?? 0);
                                            $adminTotal = $adminPrice * $quantity;
                                            $adminSubtotal += $adminTotal;
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($product?->image)
                                                        <div
                                                            class="flex-shrink-0 h-32 bg-gray-100 rounded-md overflow-hidden">
                                                            <img src="{{ Storage::url($product->image) }}"
                                                                alt="{{ $product->name }}"
                                                                class="h-full w-full object-cover">
                                                        </div>
                                                    @else
                                                        <div
                                                            class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-6 w-6 text-gray-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $product->name ?? 'N/A' }}
                                                        </div>

                                                        <div class="text-sm text-gray-500">SKU:
                                                            {{ $product->sku ?? 'N/A' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if (Auth::user()->role_id == 3)
                                                    ${{ number_format($vendorPrice, 2) }}
                                                @elseif (Auth::user()->role_id == 1)
                                                    ${{ number_format($adminPrice, 2) }}
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $quantity }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                                @if (Auth::user()->role_id == 3)
                                                    ${{ number_format($vendorTotal, 2) }}
                                                @elseif (Auth::user()->role_id == 1)
                                                    ${{ number_format($adminTotal, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <!-- Totals - Using Parent Order Totals -->
                    <div class="px-8 py-6 border-t border-gray-100">
                        <div class="flex justify-end">
                            <div class="w-64">
                                <div class="flex justify-between py-2 text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    @if (Auth::user()->role_id == 3)
                                        <span class="ms-1">
                                            @if ($record->childs && $record->childs->count() > 0)
                                                <!-- Calculate total from all child orders for vendor -->
                                                @php
                                                    $totalVendorSubtotal = 0;
                                                    foreach ($record->childs as $childOrder) {
                                                        $childVendorSubtotal = 0;
                                                        foreach ($childOrder->products as $product) {
                                                            $quantity = $product->pivot->quantity;
                                                            $vendorPrice = $childOrder->vendor_total;
                                                            $childVendorSubtotal += $vendorPrice * $quantity;
                                                        }
                                                        $totalVendorSubtotal += $childVendorSubtotal;
                                                    }
                                                @endphp
                                                ${{ number_format($totalVendorSubtotal, 2) }}
                                            @else
                                                ${{ number_format($vendorSubtotal, 2) }}
                                            @endif
                                        </span>
                                    @else
                                        <span>
                                            @if ($record->childs && $record->childs->count() > 0)
                                                <!-- Calculate total from all child orders for admin -->
                                                @php
                                                    $totalAdminSubtotal = 0;
                                                    foreach ($record->childs as $childOrder) {
                                                        $childAdminSubtotal = 0;
                                                        foreach ($childOrder->products as $product) {
                                                            $quantity = $product->pivot->quantity;
                                                            $adminPrice =
                                                                $product->sale_price ?? ($product->price ?? 0);
                                                            $childAdminSubtotal += $adminPrice * $quantity;
                                                        }
                                                        $totalAdminSubtotal += $childAdminSubtotal;
                                                    }
                                                @endphp
                                                ${{ number_format($totalAdminSubtotal, 2) }}
                                            @else
                                                ${{ number_format($adminSubtotal, 2) }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                                <div class="flex justify-between py-2 text-sm text-gray-600">
                                    <span>Shipping</span>
                                    <span>${{ number_format($record->shipping_total, 2) }}</span>
                                </div>
                                <div class="flex justify-between py-2 text-sm text-gray-600">
                                    <span>Tax</span>
                                    <span>${{ number_format($record->state_tax, 2) }}</span>
                                </div>
                                <div
                                    class="flex justify-between py-3 mt-2 border-t border-gray-200 text-base font-semibold text-primary-600">
                                    <span>Total</span>
                                    @if (Auth::user()->role_id == 3)
                                        <span>
                                            @if ($record->childs && $record->childs->count() > 0)
                                                ${{ number_format($totalVendorSubtotal + $record->shipping_total + $record->state_tax, 2) }}
                                            @else
                                                ${{ number_format($vendorSubtotal + $record->shipping_total + $record->state_tax, 2) }}
                                            @endif
                                        </span>
                                    @else
                                        <span>
                                            @if ($record->childs && $record->childs->count() > 0)
                                                ${{ number_format($totalAdminSubtotal + $record->shipping_total + $record->state_tax, 2) }}
                                            @else
                                                ${{ number_format($adminSubtotal + $record->shipping_total + $record->state_tax, 2) }}
                                            @endif
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment & Shipping Information - Always shown regardless of payment status -->
                    <div class="p-6 bg-gray-50">
                        <div class="flex justify-between gap-6">
                            <!-- Payment Information -->
                            @if ($record->payment_status)
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                        Payment
                                        Information
                                    </h3>
                                    <p class="text-sm font-medium text-gray-700 mb-1">
                                        @if ($record->payment_method === 'stripe')
                                            Stripe Payment
                                        @elseif($record->payment_method)
                                            {{ ucfirst($record->payment_method) }}
                                        @else
                                            Payment
                                        @endif
                                    </p>

                                    @if ($record->transaction_id)
                                        <p class="text-sm text-gray-500">Transaction ID: {{ $record->transaction_id }}
                                        </p>
                                    @endif
                                </div>
                            @else
                                <div>
                                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">
                                        Payment
                                        Information
                                    </h3>
                                    <p class="text-sm text-gray-500">Payment pending</p>
                                </div>
                            @endif

                            <!-- Shipping Information -->
                            <div>
                                <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">To
                                </h3>
                                @php
                                    $shipping = $record->shipping;

                                    if (is_string($shipping)) {
                                        $shipping = json_decode($shipping);
                                    }

                                    $shipping = (object) $shipping;
                                @endphp

                                <p class="font-bold">
                                    {{ $shipping->firstName ?? '' }} {{ $shipping->lastName ?? '' }}
                                </p>

                                @if (!empty($shipping->address_line))
                                    <p class="text-sm">{{ $shipping->address_line }}</p>
                                @endif

                                <p class="text-sm">
                                    {{ $shipping->city ?? '' }}, {{ $shipping->state ?? '' }}
                                </p>

                                <p class="text-sm">
                                    {{ $shipping->country_code ?? '' }} - {{ $shipping->post_code ?? '' }}
                                </p>

                                <p class="text-sm mt-2">
                                    Phone: {{ $shipping->phone ?? '' }}
                                </p>

                                <p class="text-sm">
                                    Email: {{ $shipping->email ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-8 py-4 bg-white border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-500">Thank you for your business!</p>
                        <div class="flex space-x-4 no-print gap-3">
                            <x-filament::button color="primary" icon="heroicon-o-printer"
                                onclick="printDiv('printableArea')" class=" md:w-auto rounded-md"
                                style="backdrop-filter: blur(5px); background-color: rgba(var(--primary-600), var(--tw-text-opacity)); color: white;">
                                Print Invoice
                            </x-filament::button>
                            <x-filament::button color="secondary" icon="heroicon-o-arrow-down-tray"
                                style="background-color: #209EBB; color: white;">
                                Download PDF
                            </x-filament::button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-filament::page>

