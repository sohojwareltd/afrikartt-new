@props(['shop', 'vendorData'])

@php
    $hasProductionData =
        !empty($vendorData['product_categories']) ||
        !empty($vendorData['materials_used']) ||
        !empty($vendorData['production_capacity']) ||
        !empty($vendorData['lead_time']) ||
        !empty($vendorData['quality_control']) ||
        !empty($vendorData['certifications']) ||
        !empty($vendorData['packaging_type']) ||
        !empty($vendorData['storage_conditions']) ||
        !empty($vendorData['export_standards']);
@endphp

<div x-show="tab === 'production'" x-cloak>
    @if ($hasProductionData)
        <section x-data="{ isCollapsed: false }"
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Production Details
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Manufacturing and quality information
                        </p>
                    </div>
                </div>
            </header>

            <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                <div class="fi-section-content p-6">
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] gap-6">

                        <x-shop.field-display label="Product Categories" :value="$vendorData['product_categories'] ?? null" col-span="2" />
                        <x-shop.field-display label="Materials Used" :value="$vendorData['materials_used'] ?? null" col-span="2" />
                        <x-shop.field-display label="Production Capacity" :value="$vendorData['production_capacity'] ?? null" />
                        <x-shop.field-display label="Lead Time" :value="$vendorData['lead_time'] ?? null" />
                        <x-shop.field-display label="Quality Control Process" :value="$vendorData['quality_control'] ?? null" type="textarea"
                            col-span="2" />
                        <x-shop.field-display label="Certifications" :value="$vendorData['certifications'] ?? null" col-span="2" />
                        <x-shop.field-display label="Packaging Type" :value="$vendorData['packaging_type'] ?? null" />
                        <x-shop.field-display label="Storage Conditions" :value="$vendorData['storage_conditions'] ?? null" />
                        <x-shop.field-display label="Export Standards Compliance" :value="$vendorData['export_standards'] ?? null" col-span="2" />
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No Production Information</h3>
            <p class="mt-1 text-sm text-gray-500">No production details have been provided yet.</p>
        </div>
    @endif
</div>
