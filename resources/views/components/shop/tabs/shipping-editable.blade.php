@props(['shop', 'vendorData'])

<div x-show="tab === 'shipping'" x-cloak>
    <form action="{{ route('vendor.update_vendor_data') }}" method="POST">
        @csrf
        <input type="hidden" name="section" value="shipping">

        <section
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="fi-section-header-icon h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                    </svg>
                    <div class="grid flex-1 gap-y-1">
                        <h3
                            class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                            Shipping & Export
                        </h3>
                        <p class="fi-section-header-description text-sm text-gray-500 dark:text-gray-400">
                            Shipping capabilities and export information
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
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        License</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_license"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_license'] ?? '' }}" placeholder="Yes/No">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        License Number</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_license_number"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_license_number'] ?? '' }}"
                                        placeholder="Enter license number">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        Experience</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_experience"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_experience'] ?? '' }}"
                                        placeholder="Years of experience">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        Partner</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_partner"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_partner'] ?? '' }}" placeholder="Partner name">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Shipping
                                        Method</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="shipping_method"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['shipping_method'] ?? '' }}"
                                        placeholder="e.g., Air, Sea, Land">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        Port</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_port"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_port'] ?? '' }}"
                                        placeholder="Main port of export">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Shipment
                                        Frequency</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="shipment_frequency"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['shipment_frequency'] ?? '' }}"
                                        placeholder="e.g., Weekly, Monthly">
                                </div>
                            </div>
                        </div>

                        <div class="fi-fo-field-wrp">
                            <div class="grid gap-y-2">
                                <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Export
                                        Readiness</span>
                                </label>
                                <div
                                    class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white dark:bg-white/5 ring-gray-950/10 dark:ring-white/20 focus-within:ring-2 focus-within:ring-primary-600">
                                    <input type="text" name="export_readiness"
                                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-950 dark:text-white focus:ring-0"
                                        value="{{ $vendorData['export_readiness'] ?? '' }}"
                                        placeholder="Ready status">
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
                Save Shipping Information
            </button>
        </div>
    </form>
</div>
