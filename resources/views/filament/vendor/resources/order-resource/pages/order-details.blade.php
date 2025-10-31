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

                body {
                    background: white !important;
                }

                .print-shadow-none {
                    box-shadow: none !important;
                }
            }
        </style>
    @endpush
    @php
        $order = $record;

        $shipping = is_string($record->shipping) ? json_decode($record->shipping) : $record->shipping;
    @endphp

    <div id="body" class="bg-gray-50 font-sans text-gray-700 print:bg-white">
        <div class="mx-auto my-8 print:my-0">
            <!-- Invoice Container -->
            <div
                class="bg-white shadow-sm print-shadow-none overflow-hidden p-6 mt-6 mb-5 print:border print:border-gray-200">
                <div id="printableArea">
                    <!-- Header with gradient -->
                    <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-8 py-6 print:py-4">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="flex items-center space-x-3 gap-3">
                                <!-- Logo -->
                                <div class="bg-white p-2 rounded-lg shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold">{{ $record->shop->name }}</h1>
                                    <p class="text-primary-100 text-sm">{{ $record->shop->email }}</p>
                                </div>
                            </div>
                            {{-- <div class="text-right">
                                <a href="" class="px-4 py-2 rounded-md text-white"
                                    style="background-color: #08808E">Send Massage</a>
                            </div> --}}
                        </div>
                    </div>

                    <!-- Invoice Meta -->
                    <div class="px-8 py-6 border-b border-gray-100">
                        <div class="px-8 py-6 flex justify-between">
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice Date
                                </h3>
                                <p class="mt-1 text-sm font-medium">{{ $record->created_at->format('F j, Y') }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Order Number
                                </h3>
                                <p class="mt-1 text-sm font-medium">#ORD-{{ now()->format('Y') }}-{{ $record->id }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</h3>
                                <p class="mt-1 text-sm font-medium">
                                    @if ($order->status == 0)
                                        <span
                                            class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif($order->status == 1)
                                        <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800">Paid</span>
                                    @elseif($order->status == 2)
                                        <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-800">One its
                                            way</span>
                                    @elseif($order->status == 3)
                                        <span class="px-2 py-1 rounded-full bg-red-100 text-red-800">Cancelled</span>
                                    @elseif($order->status == 4)
                                        <span
                                            class="px-2 py-1 rounded-full bg-green-100 text-green-800">Delivered</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- From/To -->
                    <div class="px-8 py-6 px-8 py-6 flex justify-between flex md:grid-cols-2 gap-8 border-b border-gray-100">
                        <div class="bg-gray-50 p-4 rounded-lg w-1/2">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">From</h3>
                            <div class="space-y-2">
                                <p class="font-medium text-gray-900">{{ $record->shop->name }}</p>
                                <p class="text-sm text-gray-600">{{ $record->shop->address }}</p>
                                <p class="text-sm text-gray-600">{{ $record->shop->state }}, {{ $record->shop->city }},
                                    {{ $record->shop->post_code }}</p>
                                <p class="text-sm text-gray-600 mt-3">Phone: {{ $record->shop->phone }}</p>
                                <p class="text-sm text-gray-600">Email: {{ $record->shop->email }}</p>
                            </div>
                        </div>


                        <div class="bg-gray-50 p-4 rounded-lg w-1/2">
                            <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-3">To</h3>
                            <div class="space-y-2">
                                <p class="font-medium text-gray-900">{{ $shipping->first_name ?? '' }}
                                    {{ $shipping->last_name ?? '' }}</p>
                                <p class="text-sm text-gray-600">{{ $shipping->address ?? '' }}</p>
                                <p class="text-sm text-gray-600">{{ $shipping->city ?? '' }},
                                    {{ $shipping->state ?? '' }}, {{ $shipping->post_code ?? '' }}</p>
                                <p class="text-sm text-gray-600">{{ $shipping->country ?? '' }}</p>
                                <p class="text-sm text-gray-600 mt-3">Phone: {{ $shipping->phone ?? '' }}</p>
                                <p class="text-sm text-gray-600">Email: {{ $shipping->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="px-0 overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Item</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Price</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Qty</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amount</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            @if ($record->product->image)
                                                <div class="flex-shrink-0 h-32 bg-gray-100 rounded-md overflow-hidden">
                                                    <img src="{{ Storage::url($record->product->image) }}"
                                                        alt="{{ $record->product->name }}"
                                                        class="h-full w-full object-cover">
                                                </div>
                                            @else
                                                <div
                                                    class="flex-shrink-0 h-12 w-12 bg-gray-100 rounded-md flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                        stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $record->product->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">SKU: {{ $record->product->sku }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ Sohoj::price($record->product->vendor_price) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $record->quantity }}
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                        {{ Sohoj::price($record->product->vendor_price * $record->quantity) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Totals -->
                    <div class="px-8 py-6 border-t border-gray-200">
                        <div class="flex justify-end">
                            <div class="w-72 space-y-3">
                                {{-- <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Subtotal</span>
                                <span class="text-sm font-medium">{{ Sohoj::price($record->subtotal) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Shipping</span>
                                <span class="text-sm font-medium">{{ $record->shipping_total }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Tax</span>
                                <span class="text-sm font-medium">{{ $record->tax ?? '0.00' }}</span>
                            </div> --}}
                                <div class="pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-semibold">Total Vendor Amount :</span>
                                        <span class="text-base font-semibold text-primary-600">
                                            {{ Sohoj::price($record->vendor_total) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Actions -->
                    <div class="p-6 bg-gray-50 rounded-lg no-print">
                        <h3 class="text-lg font-semibold text-center text-gray-700 mb-5">Order Actions</h3>

                        <div class="flex flex-wrap justify-center gap-4">

                            @if ($record->status == 0 || $record->status == 1)
                                @if ($order->cancel_request == 1)
                                    <a href="{{ route('vendor.order.cancel', ['order' => $order->id]) }}"
                                        class="px-4 py-2 bg-gray-600 text-white font-medium rounded-md hover:bg-gray-700 transition-colors">
                                        Accept Cancel Request
                                    </a>
                                @else
                                    <a href="{{ route('vendor.order.cancel', ['order' => $order->id]) }}"
                                        class="px-4 py-2 text-white font-medium rounded-md"
                                        style="background-color: rgb(152, 12, 12)">
                                        Cancel Order
                                    </a>
                                @endif
                            @endif
                            @if ($order->status == 3)
                                <span class="px-4 py-2 text-white rounded-md"
                                    style="background-color: rgb(152, 12, 12)">
                                    Order Canceled
                                </span>
                            @endif

                            @if ($order->status == 1 || $order->status == 2)
                                <button onclick="toggleTrackingInput()"
                                    class="px-4 py-2 text-white font-medium rounded-md"
                                    style="background-color: #0077B6">
                                    Add Tracking Info
                                </button>
                            @endif

                            @if ($order->status == 2)
                                <a href="{{ route('vendor.order.action', ['order' => $order->id]) }}"
                                    class="px-4 py-2 text-white font-medium rounded-md"
                                    style="background-color: #10B981;">
                                    Order Delivered
                                </a>
                            @endif

                            @if ($order->status == 4)
                                <span class="px-4 py-2 text-white" style="background-color: #62C4C3">Order has Been
                                    Delivered</span>
                            @endif

                            @if ($order->status == 5)
                                <a href="{{ route('vendor.refund.request.accept', $order) }}"
                                    class="px-4 py-2 {{ $order->refund_request_accpet == 1 ? 'bg-green-600' : 'bg-blue-600' }} text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                                    {{ $order->refund_request_accpet == 1 ? 'Refund Accepted' : 'Accept Refund' }}
                                </a>

                                @if ($order->returned_product_received != 1)
                                    <a href="{{ route('vendor.returned.product.received', ['order' => $order]) }}"
                                        class="px-4 py-2 bg-purple-600 text-white font-medium rounded-md hover:bg-purple-700 transition-colors">
                                        Product Received
                                    </a>
                                @endif
                            @endif
                        </div>

                        <!-- Tracking Form (hidden by default) -->
                        <div id="trackingInputContainer"
                            class="hidden mt-6 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                            <form action="{{ route('vendor.order.shipping') }}" method="post" class="space-y-4">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_method"
                                            class="block text-sm font-medium text-gray-700 mb-1">Shipping
                                            Carrier</label>
                                        <select name="shipping_method" id="shipping_method"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                            @php $partners = ['DHL', 'Hermes', 'DPD', 'UPS', 'GLS', 'Fedex']; @endphp
                                            @foreach ($partners as $partner)
                                                <option value="{{ $partner }}"
                                                    @if ($partner === $order->shipping_method) selected @endif>
                                                    {{ $partner }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="trackingUrlInput"
                                            class="block text-sm font-medium text-gray-700 mb-1">Tracking
                                            Number</label>
                                        <input type="text" id="trackingUrlInput" name="shipping_url"
                                            value="{{ $order->shipping_url ? $order->shipping_url : '' }}"
                                            placeholder="Enter Tracking ID"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                    </div>

                                    <div>
                                        <label for="shipping_date"
                                            class="block text-sm font-medium text-gray-700 mb-1">Shipping Date</label>
                                        <input type="date" id="shipping_date" name="shipping_date"
                                            value="{{ $order->shipping_date ? Carbon\Carbon::parse($order->shipping_date)->format('Y-m-d') : '' }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500">
                                        @error('shipping_date')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3 pt-2">
                                    <button type="button" onclick="toggleTrackingInput()"
                                        class="px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-md hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-primary-600 text-white font-medium rounded-md hover:bg-primary-700 transition-colors">
                                        Save Tracking
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Tracking Links -->
                        @if ($order->shipping_url)
                            <div class="mt-6 pt-6 border-t border-gray-200 flex justify-center gap-3 items-center">
                                @if ($order->shipping_url == !null)
                                    <div class="flex flex-wrap gap-3">
                                        @if ($order->shipping_method == 'DHL')
                                            <a href="https://nolp.dhl.de/nextt-online-public/set_identcodes.do?lang=de&idc={{ $order->tracking_Id }}"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with DHL
                                            </a>
                                        @endif
                                        @if ($order->shipping_method == 'Hermes')
                                            <a href="https://www.myhermes.de/empfangen/sendungsverfolgung/suchen/sendungsinformation/{{ $order->tracking_Id }}"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with Hermes
                                            </a>
                                        @endif
                                        @if ($order->shipping_method == 'DPD')
                                            <a href="https://tracking.dpd.de/parcelstatus?query={{ $order->tracking_Id }}&locale=de_DE"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with DPD
                                            </a>
                                        @endif
                                        @if ($order->shipping_method == 'UPS')
                                            <a href="http://wwwapps.ups.com/WebTracking/processInputRequest?sort_by=status&tracknums_displayed=1&TypeOfInquiryNumber=T&loc=de_DE&InquiryNumber1={{ $order->tracking_Id }}&track.x=0&track.y=0"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with UPS
                                            </a>
                                        @endif
                                        @if ($order->shipping_method == 'GLS')
                                            <a href="https://www.gls-pakete.de/sendungsverfolgung?match={{ $order->tracking_Id }}&txtAction=71000"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with GLS
                                            </a>
                                        @endif
                                        @if ($order->shipping_method == 'Fedex')
                                            <a href="https://www.fedex.com/fedextrack/?tracknumbers={{ $order->tracking_Id }}&locale=de_DE&cntry_code=de"
                                                target="_blank" class="px-3 py-1.5 text-white text-sm rounded"
                                                style="background-color: #5193B3">
                                                Track with Fedex
                                            </a>
                                        @endif
                                    </div>
                                @endif
                                <a href="{{ route('vendor.invoice', $order) }}"
                                    class="px-3 py-1.5 text-white text-sm rounded"
                                    style="background-color: #209EBB">Order
                                    Details
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Info -->
                    <div class="p-6 bg-gray-50 rounded-lg">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase tracking-wider mb-4">Payment
                            Information
                        </h3>

                        <div class="px-8 py-6 flex justify-between gap-3">
                            <div class="bg-white p-4 rounded-lg border border-gray-200 w-1/2">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Bank Transfer</h4>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <p>Bank Name: Chase Bank</p>
                                    <p>Account Name: {{ $shipping->first_name ?? '' }}
                                        {{ $shipping->last_name ?? '' }}</p>
                                    <p>Account Number: XXXX-XXXX-XXXX</p>
                                    <p>Routing Number: XXXX-XXXX</p>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg border border-gray-200 w-1/2">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Online Payment</h4>
                                <div class="space-y-1 text-sm text-gray-600">
                                    <p>PayPal: paypal.me/yourstore</p>
                                    <p>Stripe: checkout.yourstore.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-8 py-4 bg-white border-t border-gray-200 rounded-b-lg no-print">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-sm text-gray-500">Thank you for your business!</p>
                        <div class="flex flex-wrap gap-3">
                            <button color="primary" icon="heroicon-o-printer" onclick="printDiv('printableArea')"
                                class="w-full md:w-auto py-2 px-4 rounded-md" style="backdrop-filter: blur(5px); background-color: rgba(var(--primary-600), var(--tw-text-opacity)); color: white;">
                                Print Invoice
                            </button>
                            <a href="#" icon="heroicon-o-arrow-down-tray"
                                class="w-full md:w-auto py-2 px-4 text-center rounded-md"
                                style="background-color: #209EBB; color: white;">
                                Download PDF
                            </a>
                            <a href="{{ \App\Filament\Vendor\Resources\OrderResource\Pages\ViewOrder::getUrl(['record' => $record]) }}"
                                class="py-2 px-4 w-full text-center rounded-md"
                                style="background-color: #207184; color: white;">
                                View Order Details
                            </a>
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
