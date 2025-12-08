@props(['shop', 'vendorData'])

@php
    $hasBusinessData =
        !empty($vendorData['contact_person']) ||
        !empty($vendorData['business_type']) ||
        !empty($vendorData['years_operation']) ||
        !empty($vendorData['employee_count']) ||
        !empty($vendorData['website_social']);
@endphp

<div x-show="tab === 'business'" x-cloak>
    @if ($hasBusinessData)
        <section x-data="{ isCollapsed: false }"
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
            id="business-information">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Business Information
                        </h3>
                        <p
                            class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                            Company and business details
                        </p>
                    </div>
                </div>
            </header>

            <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                <div class="fi-section-content p-6">
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] gap-6">

                        @if (!empty($vendorData['contact_person']))
                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                <div class="grid gap-y-2">
                                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                        <span
                                            class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Contact
                                            Person</span>
                                    </label>
                                    <div
                                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                        <div class="fi-input-wrp-input min-w-0 flex-1">
                                            <input type="text" disabled
                                                class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                                                value="{{ $vendorData['contact_person'] ?? 'N/A' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($vendorData['business_type']))
                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                <div class="grid gap-y-2">
                                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                        <span
                                            class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Business
                                            Type</span>
                                    </label>
                                    <div
                                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                        <div class="fi-input-wrp-input min-w-0 flex-1">
                                            <input type="text" disabled
                                                class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                                                value="{{ $vendorData['business_type'] ?? 'N/A' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($vendorData['years_operation']))
                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                <div class="grid gap-y-2">
                                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Years
                                            in Operation</span>
                                    </label>
                                    <div
                                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                        <div class="fi-input-wrp-input min-w-0 flex-1">
                                            <input type="text" disabled
                                                class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                                                value="{{ $vendorData['years_operation'] ?? 'N/A' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($vendorData['employee_count']))
                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                <div class="grid gap-y-2">
                                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                        <span
                                            class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Employee
                                            Count</span>
                                    </label>
                                    <div
                                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                        <div class="fi-input-wrp-input min-w-0 flex-1">
                                            <input type="text" disabled
                                                class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                                                value="{{ $vendorData['employee_count'] ?? 'N/A' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (!empty($vendorData['website_social']))
                            <div data-field-wrapper="" class="fi-fo-field-wrp col-span-full">
                                <div class="grid gap-y-2">
                                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                        <span
                                            class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Website/Social
                                            Media</span>
                                    </label>
                                    <div
                                        class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                        <div class="fi-input-wrp-input min-w-0 flex-1">
                                            <input type="text" disabled
                                                class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                                                value="{{ $vendorData['website_social'] ?? 'N/A' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @else
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No Business Information</h3>
            <p class="mt-1 text-sm text-gray-500">No business information has been provided yet.</p>
        </div>
    @endif
</div>
