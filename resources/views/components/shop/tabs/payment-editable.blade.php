@props(['shop', 'vendorData'])

@php
    $bankAccount = $shop->user->defaultBankAccount;
@endphp

<div x-show="tab === 'payment'" x-cloak>
    <form action="{{ route('vendor.update_bank_account') }}" method="POST">
        @csrf
        @if ($bankAccount)
            <input type="hidden" name="bank_account_id" value="{{ $bankAccount->id }}">
        @endif

        <section
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Payment & Banking
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Banking and payment preferences
                        </p>
                    </div>
                </div>
            </header>

            <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                <div class="fi-section-content p-6">
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] gap-6">

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span
                                        class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Beneficiary
                                        Name</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="beneficiary_name"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['beneficiary_name'] ?? '' }}"
                                        placeholder="Account holder name">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Bank
                                        Name</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="bank_name"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $bankAccount->bank_name ?? '' }}" placeholder="Name of the bank">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Account
                                        Number</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="account_number"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $bankAccount->account_number ?? '' }}"
                                        placeholder="Bank account number">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">SWIFT
                                        Code</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="swift_code"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $bankAccount->swift_code ?? '' }}" placeholder="SWIFT/BIC code">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Routing
                                        Number</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="routing_number"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $bankAccount->routing_number ?? '' }}"
                                        placeholder="Bank routing number">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span
                                        class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Currency</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="currency"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['currency'] ?? '' }}" placeholder="e.g., USD, EUR">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp col-span-full">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Payment
                                        Frequency</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="payment_frequency"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['payment_frequency'] ?? '' }}"
                                        placeholder="e.g., Weekly, Monthly">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="flex justify-end mt-6 px-6 pb-6">
            <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Save Bank Account
            </button>
        </div>
    </form>
</div>
