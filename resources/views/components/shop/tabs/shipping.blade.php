@props(['shop', 'vendorData'])

@php
    $hasShippingData =
        !empty($vendorData['export_license']) ||
        !empty($vendorData['export_license_number']) ||
        !empty($vendorData['export_experience']) ||
        !empty($vendorData['export_partner']) ||
        !empty($vendorData['shipping_method']) ||
        !empty($vendorData['export_port']) ||
        !empty($vendorData['shipment_frequency']) ||
        !empty($vendorData['export_readiness']);
@endphp

<div x-show="tab === 'shipping'" x-cloak>
    @if ($hasShippingData)
        <section x-data="{ isCollapsed: false }"
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Shipping & Export Information
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Export capabilities and shipping details
                        </p>
                    </div>
                </div>
            </header>

            <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                <div class="fi-section-content p-6">
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] gap-6">

                        <x-shop.field-display label="Export License" :value="$vendorData['export_license'] ?? null" />
                        <x-shop.field-display label="Export License Number" :value="$vendorData['export_license_number'] ?? null" />
                        <x-shop.field-display label="Export Experience" :value="$vendorData['export_experience'] ?? null" />
                        <x-shop.field-display label="Export Partner/Agent" :value="$vendorData['export_partner'] ?? null" />
                        <x-shop.field-display label="Preferred Shipping Method" :value="$vendorData['shipping_method'] ?? null" />
                        <x-shop.field-display label="Export Port" :value="$vendorData['export_port'] ?? null" />
                        <x-shop.field-display label="Shipment Frequency" :value="$vendorData['shipment_frequency'] ?? null" />
                        <x-shop.field-display label="Export Readiness" :value="$vendorData['export_readiness'] ?? null" />
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No Shipping Information</h3>
            <p class="mt-1 text-sm text-gray-500">No shipping and export information has been provided yet.</p>
        </div>
    @endif
</div>
