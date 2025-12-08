@props(['shop', 'vendorData'])

@php
    $bankAccount = $shop->user->defaultBankAccount;
    $hasPaymentData = $bankAccount !== null;
@endphp

<div x-show="tab === 'payment'" x-cloak>
    @if ($hasPaymentData)
        <section x-data="{ isCollapsed: false }"
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Payment & Banking Information
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Banking details and payment preferences
                        </p>
                    </div>
                </div>
            </header>

            <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                <div class="fi-section-content p-6">
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] gap-6">

                        <x-shop.field-display label="Account Holder" :value="$bankAccount->account_holder ?? null" col-span="2" />
                        <x-shop.field-display label="Bank Name" :value="$bankAccount->bank_name ?? null" />
                        <x-shop.field-display label="Account Number" :value="$bankAccount->account_number ?? null" />
                        <x-shop.field-display label="SWIFT/BIC Code" :value="$bankAccount->swift_code ?? null" />
                        <x-shop.field-display label="Routing Number" :value="$bankAccount->routing_number ?? null" />
                        <x-shop.field-display label="Currency" :value="$bankAccount->currency ?? null" />
                        <x-shop.field-display label="Account Type" :value="$bankAccount->account_type ?? null" />
                        <x-shop.field-display label="Status" :value="ucfirst($bankAccount->status ?? '')" />
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No Payment Information</h3>
            <p class="mt-1 text-sm text-gray-500">No payment and banking information has been provided yet.</p>
        </div>
    @endif
</div>
