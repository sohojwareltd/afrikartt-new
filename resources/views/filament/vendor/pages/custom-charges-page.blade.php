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
        $charges = Auth()->user()->invoices();
        $totalAmount = $charges->sum('total') / 100;
    @endphp

    <div id="body" class="bg-gray-50 font-sans text-gray-700 print:bg-white">
        <div class=" mx-auto my-8 print:my-0">

            <!-- Invoice Container -->
            <div
                class="bg-white shadow-sm print-shadow-none overflow-hidden p-6 mt-6 mb-5 print:border print:border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-5">Charges</h2>

                <!-- Stats Cards -->
                <div class="flex gap-4 mt-5 mb-5">
                    <div
                        class="flex items-center p-4 w-[--sidebar-width] bg-white rounded-2xl shadow hover:shadow-md transition duration-300 hover:scale-105 border border-gray-100">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            <i class="fa-solid fa-wallet text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500">Total Spent</p>
                            <p class="text-xl font-bold text-gray-900">{{ Sohoj::price($totalAmount) }}</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center w-[--sidebar-width] p-4 bg-white rounded-2xl shadow hover:shadow-md transition duration-300 hover:scale-105 border border-gray-100">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-primary-100 flex items-center justify-center text-primary-600">
                            <i class="fa-solid fa-receipt text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500">Total Charges</p>
                            <p class="text-xl font-bold text-gray-900">{{ $charges->count() }}</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center w-[--sidebar-width] p-4 bg-white rounded-2xl shadow hover:shadow-md transition duration-300 hover:scale-105 border border-gray-100">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-secondary-100 flex items-center justify-center text-secondary-600">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500">This Month</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ Sohoj::price(
                                    $charges->filter(fn($c) => $c->created_at && now()->subMonth()->lt($c->created_at))->sum('total') / 100,
                                ) }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="flex items-center w-[--sidebar-width] p-4 bg-white rounded-2xl shadow hover:shadow-md transition duration-300 hover:scale-105 border border-gray-100">
                        <div
                            class="flex-shrink-0 w-12 h-12 rounded-full bg-success-100 flex items-center justify-center text-success-600">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs text-gray-500">Avg. Charge</p>
                            <p class="text-xl font-bold text-gray-900">
                                {{ $charges->count() > 0 ? Sohoj::price($totalAmount / $charges->count()) : Sohoj::price(0) }}
                            </p>
                        </div>
                    </div>
                </div>


                <div class="px-0 overflow-x-auto">
                    @if ($charges->count() == !0)
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="ps-4 px-8 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Account name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Billing Reason</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Total</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($charges as $charge)
                                    <tr class="border-b">
                                        <td class="px-6 py-4">
                                            {{ $charge->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $charge->account_name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $charge->billing_reason }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                            {{ Sohoj::price($charge->total / 100) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right text-gray-900">
                                            <a href="{{ \App\Filament\Vendor\Pages\ViewInvoice::getUrl(['invoiceId' => $charge->id]) }}" class="inline-flex items-center px-3 py-1 rounded-lg bg-primary-50 text-primary-700 font-semibold text-xs hover:bg-primary-100 transition">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 class="text-center text-danger">No Charges create</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-filament-panels::page>
