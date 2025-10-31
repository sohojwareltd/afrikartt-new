<x-filament-forms::field-wrapper label="Current Offer" statePath="current_offer" hint="Enter current promotional offer">
    <input type="text" id="current_offer" name="current_offer"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="e.g. 20% off on all items!" value="{{ old('current_offer', $settings['current_offer'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Offer Description" statePath="offer_description"
    hint="Describe your current offer">
    <textarea id="offer_description" name="offer_description" rows="3"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Describe your current offer">{{ old('offer_description', $settings['offer_description'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Offer Valid Until" statePath="offer_valid_until"
    hint="Select offer expiry date">
    <input type="date" id="offer_valid_until" name="offer_valid_until"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                                focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                                dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        value="{{ old('offer_valid_until', $settings['offer_valid_until'] ?? '') }}" />
</x-filament-forms::field-wrapper>

<x-filament-forms::field-wrapper label="Offer Banner Image" statePath="offer_banner" hint="Upload offer banner image">
    <div x-data="{ bannerPreview: null, isDragOver: false }" @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; handleFileDrop($event, 'offer_banner')">

        <div class="relative">
            <input type="file" id="offer_banner" name="offer_banner" accept="image/*"
                @change="bannerPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

            <div :class="isDragOver ? 'border-primary-400 bg-primary-50 dark:bg-primary-900/20' :
                'border-gray-300 dark:border-gray-600'"
                class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200
                                            bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700
                                            hover:border-primary-400 dark:hover:border-primary-500">

                <div class="flex flex-col items-center space-y-3">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-full">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <span class="text-primary-600 dark:text-primary-400">Upload Banner Image</span>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            PNG, JPG (1920x600 recommended)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div x-show="bannerPreview" x-cloak
            class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Banner Preview</p>
                    <button type="button"
                        @click="bannerPreview = null; document.getElementById('offer_banner').value = ''"
                        class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <img :src="bannerPreview" alt="Banner Preview"
                    class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
            </div>
        </div>

        {{-- Current Banner --}}
        @if (isset($settings['offer_banner']) && $settings['offer_banner'])
            <div x-show="!bannerPreview"
                class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="space-y-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Banner</p>
                    <img src="{{ asset('storage/' . $settings['offer_banner']) }}" alt="Current Offer Banner"
                        class="w-full h-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                </div>
            </div>
        @endif
    </div>
</x-filament-forms::field-wrapper>
