@if (Auth::user()->shop->status == 1)
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
        $methods = auth()->user()->paymentMethods();
        $status = $status == 1 ? true : false;
    @endphp


    <div id="body" class="bg-gray-50 font-sans text-gray-700 print:bg-white">
        <div class=" mx-auto my-8 print:my-0">
            <!-- Invoice Container -->
            <div
                class="bg-white shadow-sm print-shadow-none overflow-hidden p-6 mt-6 mb-5 print:border print:border-gray-200">
                <div class="px-6 py-4 border-gray-100 flex justify-between items-center border-b">
                    <h2 class="text-lg font-semibold text-gray-900">Payment Methods</h2>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded" onclick="openModal()"
                        style="background: #17a589">Add Payment Card</button>
                </div>

                <div class="px-6 py-6 border-gray-100">
                    <h4 class="text-2xl font-bold mb-5">Saved card</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-5">
                        @foreach ($methods as $payment)
                            <div>
                                <div class="max-w-sm mx-auto">
                                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl shadow-lg p-6 relative overflow-hidden"
                                        style="background: #3B556E;">
                                        <!-- Card brand -->
                                        <div class="flex justify-between items-center mb-4">
                                            <div class="text-lg font-bold text-primary-400"
                                                style="text-transform: uppercase;">
                                                {{ ucwords($payment->card->brand) }}
                                                @if (auth()->user()->getCard() && auth()->user()->getCard()->id == $payment->id)
                                                    <p class="text-xs uppercase opacity-80" style="color: #17a589">
                                                        Default
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-12 h-8" viewBox="0 0 48 32"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <rect x="0" y="0" width="48" height="32" rx="4"
                                                        ry="4" fill="#D4AF37" />
                                                    <path d="M12 0v32M24 0v32M36 0v32M0 8h48M0 16h48M0 24h48"
                                                        stroke="#8C6D1F" stroke-width="2" />
                                                </svg>
                                            </div>

                                        </div>

                                        <!-- Card number -->
                                        <div class="text-xl font-mono tracking-widest text-dark mb-6">
                                            •••• •••• •••• {{ $payment->card->last4 }}
                                        </div>

                                        <!-- Card holder and expiry -->
                                        <div class="flex justify-between items-center mb-4">
                                            <div>
                                                <div class="text-xs uppercase opacity-80">Card Holder</div>
                                                <div class="text-base font-semibold">
                                                    {{ $payment->billing_details->name . ' ' . $payment->billing_details->l_name }}
                                                </div>
                                            </div>
                                            <div>
                                                <div class="text-xs uppercase opacity-80">Expires</div>
                                                <div class="text-base font-semibold">
                                                    {{ $payment->card->exp_month }}/{{ $payment->card->exp_year }}</div>
                                            </div>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            @if (!(auth()->user()->getCard() && auth()->user()->getCard()->id == $payment->id))
                                                <button
                                                    onclick="setAsDefault('{{ route('user.setCardAsDefault', ['method' => $payment->id]) }}')"
                                                    class="px-2 text-white text-xs rounded-md"
                                                    style="background: #17a589">
                                                    Set Default
                                                </button>
                                            @endif
                                            <button
                                                onclick="confirmRemove('{{ route('user.removeCard', ['method' => $payment->id]) }}')"
                                                class="px-2 text-white text-xs rounded-md" style="background: #e74c3c;">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <h2 class="text-lg font-semibold text-gray-900 text-center py-6 text-bold">Payment Methods</h2>
                <div class="flex flex-col md:flex-row gap-4 mb-4">
                    <!-- Cancel Subscription -->
                    <div class="w-full md:w-1/2 bg-white rounded shadow p-4">
                        <h6 class="text-lg font-semibold mb-2 uppercase">Cancel your Monthly Subscription</h6>
                        <span class="text-sm text-gray-700">
                            Your subscription won't be renewed if you cancel your subscription.
                        </span>
                        <div class="flex justify-end mt-4">
                            @if ($status == true)
                                <a href="{{ route('vendor.cancelSubscription') }}"
                                    onclick="return confirm('Are you sure you want to cancel the subscription? Your subscription will be canceled after the billing cycle');"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded"
                                    style="background: #dad60c">
                                    Cancel
                                </a>
                            @else
                                <a href="{{ route('vendor.resumeSubscription') }}"
                                    onclick="return confirm('Do you want to resume your subscription?');"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded"
                                    style="background: #e74c3c">
                                    Resume
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Deactivate Shop -->
                    <div class="w-full md:w-1/2 bg-white rounded shadow p-4">
                        <h6 class="text-lg font-semibold mb-2 uppercase">Deactivate your Shop</h6>
                        <span class="text-sm text-gray-700">
                            Your shop will be deactivated. You won't be able to access any vendor features.
                        </span>
                        <div class="flex justify-end mt-4">
                            <a href="{{ route('vendor.cancelSubscriptionNow') }}"
                                onclick="return confirm('Are you sure you want to deactivate your shop?');"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
                                style="background: #e74c3c">
                                Deactivate
                            </a>
                        </div>
                    </div>
                </div>


                <div id="myModal"
                    class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                    <div class="bg-white rounded-lg shadow p-6 w-full max-w-xl">
                        <h2 class="text-xl font-semibold mb-4">Add Payment Card</h2>
                        <form id="cardAddFrom" action="{{ route('user.card.add') }}" method="POST">
                            @csrf
                            <input id="card-holder-name" type="hidden" value="{{ auth()->user()->name }}">
                            <input type="hidden" id="paymentmethod" name="payment_method" value="">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Card Details</label>
                                    <div id="card-element"
                                        class="p-3 border border-gray-300 rounded-lg bg-white shadow-sm"></div>
                                    <div id="card-errors" class="mt-2 text-sm text-red-600"></div>
                                </div>

                                <div class="flex justify-end gap-3 space-x-3 pt-2">
                                    <button type="button" onclick="closeModal()"
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button type="button" id="card-button" data-secret="{{ $intent }}"
                                        class="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium hover:bg-primary-700 flex items-center">
                                        <span id="submit-text">Save Card</span>
                                        <span id="spinner" class="hidden ml-2">
                                            <svg class="animate-spin h-4 w-4 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://js.stripe.com/v3/"></script>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
            // Set card as default
            function setAsDefault(url) {
                if (confirm('Set this card as your default payment method?')) {
                    window.location.href = url;
                }
            }

            // Confirm card removal
            function confirmRemove(url) {
                if (confirm('Are you sure you want to remove this payment method?\n\nThis action cannot be undone.')) {
                    window.location.href = url;
                }
            }
        </script>
        <script>
            const stripe = Stripe("{{ Settings::setting('stripe_key') }}");

            const elements = stripe.elements();
            const cardElement = elements.create('card');

            cardElement.mount('#card-element');

            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;

            cardButton.addEventListener('click', async (e) => {
                const {
                    setupIntent,
                    error
                } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: cardElement,
                            billing_details: {
                                name: cardHolderName.value
                            }
                        }
                    }
                );

                if (error) {
                    if (error?.setupIntent) {
                        document.getElementById('paymentmethod').value = error.setupIntent.payment_method
                        toastr.success('Card added');
                        window.location.href = url;
                    } else {
                        toastr.error('Something went wrong. Try again letter');
                    }

                } else {
                    document.getElementById('paymentmethod').value = setupIntent.payment_method
                    toastr.success('Card added');
                    $('#cardAddFrom').submit();
                    window.refresh();
                }
            });
        </script>

        <script>
            function openModal() {
                document.getElementById('myModal').classList.remove('hidden');
                document.getElementById('myModal').classList.add('flex');
            }

            function closeModal() {
                document.getElementById('myModal').classList.add('hidden');
                document.getElementById('myModal').classList.remove('flex');
            }
        </script>
    @endpush
</x-filament-panels::page>
@endif
