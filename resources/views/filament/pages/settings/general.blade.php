{{-- Site Title --}}
<x-filament-forms::field-wrapper label="Site Title" statePath="site_title" hint="Enter your website title">
    <input type="text" id="site_title" name="site_title"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                   focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Enter site title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" />
</x-filament-forms::field-wrapper>

{{-- Site Description --}}
<x-filament-forms::field-wrapper label="Site Description" statePath="site_description" hint="Short site summary">
    <textarea id="site_description" name="site_description" rows="3"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                   focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Enter site description">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>

{{-- nav image --}}

<x-filament-forms::field-wrapper label="Navbar Image" statePath="site_nav_image" hint="Logo for newsletter footer">

    <div x-data="{ navPreview: null, isDragOver: false }" @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; handleFileDrop($event, 'site_nav_image')">

        <div class="relative">
            <input type="file" name="site_nav_image" id="site_nav_image" accept="image/*"
                @change="navPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
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
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <span class="text-primary-600 dark:text-primary-400">Upload Navbar Logo</span>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            PNG, JPG, SVG up to 5MB
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div x-show="navPreview" x-cloak
            class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <img :src="navPreview" alt="Navbar Logo Preview"
                    class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />

                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Navbar Logo Preview</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">New logo will be uploaded</p>
                </div>

                <button type="button" @click="navPreview = null; document.getElementById('site_nav_image').value = ''"
                    class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Current Logo --}}
        @if (isset($settings['site_nav_image']) && $settings['site_nav_image'])
            <div x-show="!navPreview"
                class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">

                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $settings['site_nav_image']) }}" alt="Current Navbar Logo"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />

                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Navbar Logo</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ basename($settings['site_nav_image']) }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-filament-forms::field-wrapper>


{{-- Site Logo --}}
<x-filament-forms::field-wrapper label="Site Logo" statePath="site_logo" hint="Upload your site logo (PNG, JPG, SVG)">
    <div x-data="{ logoPreview: null, isDragOver: false }" @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; handleFileDrop($event, 'site_logo')">

        <div class="relative">
            <input type="file" name="site_logo" id="site_logo" accept="image/*"
                @change="logoPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
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
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <span class="text-primary-600 dark:text-primary-400">Click to upload</span>
                            or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            PNG, JPG, SVG up to 10MB
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div x-show="logoPreview" x-cloak
            class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <img :src="logoPreview" alt="Logo Preview"
                    class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Preview</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">New logo will be uploaded</p>
                </div>
                <button type="button" @click="logoPreview = null; document.getElementById('site_logo').value = ''"
                    class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Current Logo --}}
        @if (isset($settings['site_logo']) && $settings['site_logo'])
            <div x-show="!logoPreview"
                class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Logo</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ basename($settings['site_logo']) }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-forms::field-wrapper>

{{-- Google Analytics Tracking ID --}}
<x-filament-forms::field-wrapper label="Google Analytics Tracking ID" statePath="site_google_analytics_tracking_id"
    hint="UA-XXXXXXXXX-X">
    <input type="text" id="site_google_analytics_tracking_id" name="site_google_analytics_tracking_id"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                   focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="UA-XXXXXXXXX-X"
        value="{{ old('site_google_analytics_tracking_id', $settings['site_google_analytics_tracking_id'] ?? '') }}" />
</x-filament-forms::field-wrapper>

{{-- Newsletter Logo --}}
<x-filament-forms::field-wrapper label="Newsletter Logo" statePath="site_newslletter_logo"
    hint="Logo for newsletter footer">
    <div x-data="{ newsletterPreview: null, isDragOver: false }" @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; handleFileDrop($event, 'site_newslletter_logo')">

        <div class="relative">
            <input type="file" name="site_newslletter_logo" id="site_newslletter_logo" accept="image/*"
                @change="newsletterPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

            <div :class="isDragOver ? 'border-primary-400 bg-primary-50 dark:bg-primary-900/20' :
                'border-gray-300 dark:border-gray-600'"
                class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200
                                            bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700
                                            hover:border-primary-400 dark:hover:border-primary-500">

                <div class="flex flex-col items-center space-y-3">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-full">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <span class="text-primary-600 dark:text-primary-400">Upload Newsletter Logo</span>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            PNG, JPG, SVG up to 5MB
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div x-show="newsletterPreview" x-cloak
            class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <img :src="newsletterPreview" alt="Newsletter Logo Preview"
                    class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Newsletter Logo Preview</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">New logo will be uploaded</p>
                </div>
                <button type="button"
                    @click="newsletterPreview = null; document.getElementById('site_newslletter_logo').value = ''"
                    class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Current Logo --}}
        @if (isset($settings['site_newslletter_logo']) && $settings['site_newslletter_logo'])
            <div x-show="!logoPreview"
                class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $settings['site_newslletter_logo']) }}" alt="Current Logo"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Logo</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ basename($settings['site_newslletter_logo']) }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-forms::field-wrapper>

{{-- Site Icon --}}
<x-filament-forms::field-wrapper label="Site Icon" statePath="site_icon" hint="Favicon or app icon">
    <div x-data="{ iconPreview: null, isDragOver: false }" @dragover.prevent="isDragOver = true" @dragleave.prevent="isDragOver = false"
        @drop.prevent="isDragOver = false; handleFileDrop($event, 'site_icon')">

        <div class="relative">
            <input type="file" name="site_icon" id="site_icon" accept="image/*,.ico"
                @change="iconPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />

            <div :class="isDragOver ? 'border-primary-400 bg-primary-50 dark:bg-primary-900/20' :
                'border-gray-300 dark:border-gray-600'"
                class="relative border-2 border-dashed rounded-xl p-6 text-center transition-all duration-200
                                            bg-gray-50 hover:bg-gray-100 dark:bg-gray-800 dark:hover:bg-gray-700
                                            hover:border-primary-400 dark:hover:border-primary-500">

                <div class="flex flex-col items-center space-y-3">
                    <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-full">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                        </svg>
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                            <span class="text-primary-600 dark:text-primary-400">Upload Favicon</span>
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            ICO, PNG (32x32 recommended)
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Preview --}}
        <div x-show="iconPreview" x-cloak
            class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                <img :src="iconPreview" alt="Icon Preview"
                    class="w-8 h-8 object-cover rounded border border-gray-200 dark:border-gray-600" />
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Favicon Preview</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">New icon will be uploaded</p>
                </div>
                <button type="button" @click="iconPreview = null; document.getElementById('site_icon').value = ''"
                    class="p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        {{-- @dd($settings['site_icon']) --}}
        {{-- Current Logo --}}
        @if (isset($settings['site_icon']) && $settings['site_icon'])
            <div x-show="!logoPreview"
                class="mt-3 p-4 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $settings['site_icon']) }}" alt="Current Logo"
                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-gray-600" />
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Current Logo</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ basename($settings['site_icon']) }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-forms::field-wrapper>

{{-- Shop Settings Info --}}
<x-filament-forms::field-wrapper label="Shop Settings Info" statePath="site_shop_settings_info"
    hint="Optional extra shop info">
    <textarea id="site_shop_settings_info" name="site_shop_settings_info" rows="4"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm
               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Enter shop info">{{ old('site_shop_settings_info', $settings['site_shop_settings_info'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>


{{-- Site Phone --}}
<x-filament-forms::field-wrapper label="Phone" statePath="site_phone" hint="Customer support number">
    <input type="text" id="site_phone" name="site_phone"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                   focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="+8801XXXXXXXXX" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}" />
</x-filament-forms::field-wrapper>

{{-- Site Email --}}
<x-filament-forms::field-wrapper label="Email" statePath="site_email" hint="Support contact email">
    <input type="email" id="site_email" name="site_email"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                   focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                   dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="support@example.com" value="{{ old('site_email', $settings['site_email'] ?? '') }}" />
</x-filament-forms::field-wrapper>

{{-- Site Announcement --}}
<x-filament-forms::field-wrapper label="Site Announcement" statePath="site_announcement"
    hint="Announcement text to show on top of the site">
    <textarea id="site_announcement" name="site_announcement" rows="3"
        class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm
               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
        placeholder="Enter site announcement">{{ old('site_announcement', $settings['site_announcement'] ?? '') }}</textarea>
</x-filament-forms::field-wrapper>
