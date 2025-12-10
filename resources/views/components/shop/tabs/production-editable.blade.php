@props(['shop', 'vendorData'])

<div x-show="tab === 'production'" x-cloak>
    <form action="{{ route('vendor.update_vendor_data') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="production">

        <section
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Production Details
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Manufacturing and production capabilities
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
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Product
                                        Categories</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <textarea name="product_categories" rows="2"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        placeholder="Enter product categories">{{ $vendorData['product_categories'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Materials
                                        Used</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <textarea name="materials_used" rows="2"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        placeholder="Enter materials used">{{ $vendorData['materials_used'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Production
                                        Capacity</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="production_capacity"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['production_capacity'] ?? '' }}"
                                        placeholder="e.g., 10,000 units/month">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Lead
                                        Time</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="lead_time"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['lead_time'] ?? '' }}" placeholder="e.g., 2-3 weeks">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Quality
                                        Control</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="quality_control"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['quality_control'] ?? '' }}"
                                        placeholder="Quality control measures">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span
                                        class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Certifications</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="certifications"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['certifications'] ?? '' }}"
                                        placeholder="e.g., ISO 9001, CE">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Packaging
                                        Type</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="packaging_type"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['packaging_type'] ?? '' }}"
                                        placeholder="Packaging details">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Storage
                                        Conditions</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="storage_conditions"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['storage_conditions'] ?? '' }}"
                                        placeholder="Storage requirements">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp col-span-full">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        Standards</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <textarea name="export_standards" rows="2"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        placeholder="Export compliance and standards">{{ $vendorData['export_standards'] ?? '' }}</textarea>
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
                Save Production Details
            </button>
        </div>
    </form>
</div>
