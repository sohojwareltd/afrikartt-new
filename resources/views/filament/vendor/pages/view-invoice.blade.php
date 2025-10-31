<x-filament-panels::page>
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
            }
        </style>
    @endpush
    @php
        $charge = auth()->user()->findInvoice($invoiceId);
    @endphp

    <div id="body" class="bg-gray-50 font-sans text-gray-700">
        <div class="max-w-4xl mx-auto my-8">
            <!-- Invoice Container -->
            <div class="bg-white  shadow-sm overflow-hidden p-6 mt-6 mb-5">
                <!-- Header with gradient -->
                <div class="bg-gradient-to-r from-primary-500 to-secondary-500 px-8 py-6">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <!-- Replace with your logo -->
                            <div class="bg-white p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                            </div>
                            <h1 class="text-2xl font-bold text-black">Subscription Invoice</h1>
                        </div>
                        <div class="text-right">
                            <h2 class="text-3xl font-bold text-white">INVOICE</h2>
                            <p class="text-primary-100 font-medium">
                                #INV-{{ now()->format('Y') }}-{{ str_replace('_', ' ', $charge->billing_reason) }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- From/To -->
                <div class="px-8 py-6 flex justify-between border-b border-gray-100">
                    <div>
                        {{-- @dd($record->shop) --}}
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">From</h3>
                        <p class="font-bold">Billing Details</p>
                        <p class="text-sm">Name :{{ auth()->user()->name . ' ' . auth()->user()->i_name }}</p>
                        <p class="text-sm">Email: {{ auth()->user()->email }}</p>
                        <p class="text-sm">
                            {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->address_1 : '' }},<br>
                            {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->city : '' }},<br>
                            {{ auth()->user()->shopAddress ? auth()->user()->shopAddress->country : '' }}
                        </p>
                        {{-- <p class="text-sm mt-2">Phone: {{ $record->shop->phone }}</p> --}}
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">INVOICE DETAILS
                        </h3>
                        <p class="font-bold">Date Issued : {{ $charge->date()->toFormattedDateString() }}</p>
                        <p class="text-sm">Payment Method :
                            {{ ucwords(auth()->user()->getCard() ? auth()->user()->getCard()->card->brand : '') }}</p>
                        <p class="text-sm">
                            •••• {{ auth()->user()->getCard() ? auth()->user()->getCard()->card->last4 : '' }}
                        </p>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="px-0 overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="ps-4 px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Description</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                    Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4">
                                    {{ str_replace('_', ' ', $charge->billing_reason) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ Sohoj::price($charge->amount_paid / 100) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4">
                                    Taxes
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ Sohoj::price($charge->tax) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-6 border-t border-gray-100">
                    <div class="flex justify-end">
                        <div class="w-64">
                            <div
                                class="flex justify-between py-3 mt-2 border-t border-gray-200 text-base font-semibold text-primary-600">
                                <span>Total</span>
                                <span> {{ Sohoj::price($charge->total / 100) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="p-6 bg-gray-50 ">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Payment Information
                    </h3>
                    <div class="flex justify-between gap-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Bank Transfer</p>
                            <p class="text-sm text-gray-500">Bank Name: Chase Bank</p>
                            <p class="text-sm text-gray-500">Account Name: YourStore Inc.</p>
                            <p class="text-sm text-gray-500">Account Number: XXXX-XXXX-XXXX</p>
                            <p class="text-sm text-gray-500">Routing Number: XXXX-XXXX</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-1">Online Payment</p>
                            <p class="text-sm text-gray-500">PayPal: paypal.me/yourstore</p>
                            <p class="text-sm text-gray-500">Stripe: checkout.yourstore.com</p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-8 py-4 bg-white border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-500">Thank you for your business!</p>
                        <div class="flex space-x-4 no-print gap-3">
                            <x-filament::button color="primary" icon="heroicon-o-printer" id="print-invoice-btn">
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const printBtn = document.getElementById('print-invoice-btn');
                if (printBtn) {
                    printBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        window.print();
                    });
                }
            });
        </script>
    @endpush
</x-filament-panels::page>
