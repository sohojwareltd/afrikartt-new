@props(['shop', 'vendorData'])

<div x-show="tab === 'business'" x-cloak>
    <form action="{{ route('vendor.update_vendor_data') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="business">

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

                        <div data-field-wrapper="" class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Contact
                                        Person</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <div class="fi-input-wrp-input min-w-0 flex-1">
                                        <input type="text" name="contact_person"
                                            class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                            value="{{ $vendorData['contact_person'] ?? '' }}"
                                            placeholder="Enter contact person name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-field-wrapper="" class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Business
                                        Type</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <div class="fi-input-wrp-input min-w-0 flex-1">
                                        <input type="text" name="business_type"
                                            class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                            value="{{ $vendorData['business_type'] ?? '' }}"
                                            placeholder="e.g., Manufacturer, Distributor">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-field-wrapper="" class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Years in
                                        Operation</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <div class="fi-input-wrp-input min-w-0 flex-1">
                                        <input type="number" name="years_operation"
                                            class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                            value="{{ $vendorData['years_operation'] ?? '' }}"
                                            placeholder="Enter years">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-field-wrapper="" class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Employee
                                        Count</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <div class="fi-input-wrp-input min-w-0 flex-1">
                                        <input type="number" name="employee_count"
                                            class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                            value="{{ $vendorData['employee_count'] ?? '' }}"
                                            placeholder="Enter number of employees">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div data-field-wrapper="" class="fi-fo-field-wrp col-span-full">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span
                                        class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Website/Social
                                        Media</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <div class="fi-input-wrp-input min-w-0 flex-1">
                                        <input type="text" name="website_social"
                                            class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                            value="{{ $vendorData['website_social'] ?? '' }}"
                                            placeholder="Enter website or social media links">
                                    </div>
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
                Save Business Information
            </button>
        </div>
    </form>
</div>
