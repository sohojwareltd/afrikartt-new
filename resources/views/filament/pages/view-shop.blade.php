<x-filament-panels::page>
    @push('styles')
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'system-ui', 'sans-serif'],
                        },
                    }
                }
            }
        </script>
        <style>
            .profile-card {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .profile-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }

            .tab-button {
                transition: all 0.2s ease-in-out;
            }

            .tab-button.active {
                background: darkcyan;
                color: white;
            }

            .form-section {
                animation: fadeIn 0.5s ease-in-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .avatar-upload {
                position: relative;
                display: inline-block;
            }

            .avatar-upload:hover .avatar-overlay {
                opacity: 1;
            }

            .avatar-banner-upload {
                position: relative;
            }

            .avatar-banner-upload:hover .avatar-banner-overlay {
                opacity: 1;
            }

            .avatar-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .avatar-banner-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .progress-ring {
                transform: rotate(-90deg);
            }

            .progress-ring-circle {
                transition: stroke-dasharray 0.35s;
                transform-origin: 50% 50%;
            }

            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .status-indicator {
                animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.5;
                }
            }
        </style>
    @endpush

    @php
        $user = Auth::user();
        $shop = $record;

        $userFields = ['name', 'l_name', 'email'];
        $shopFields = [
            'name',
            'logo',
            'banner',
            'short_description',
            'company_name',
            'company_registration',
            'description',
            'phone',
            'email',
            'city',
            'state',
            'post_code',
            'country',
        ];

        $userCompleted = collect($userFields)->filter(fn($field) => !empty($user->$field))->count();
        $shopCompleted = collect($shopFields)->filter(fn($field) => !empty($shop->$field))->count();
        $totalFields = count($userFields) + count($shopFields);
        $completedFields = $userCompleted + $shopCompleted;
        $profileCompletion = round(($completedFields / $totalFields) * 100);
        $radius = 28;
        $circumference = 2 * M_PI * $radius;
        $offset = $circumference * (1 - $profileCompletion / 100);
    @endphp

    <!-- Single root element wrapper -->
    <div>
        <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

                <div class="mb-8">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="">
                            <div class="card">
                                <div class="card-header avatar-banner-upload">
                                    @php
                                        $bannerPath = $shop ? $shop->banner : null;
                                        $extension = $bannerPath
                                            ? strtolower(pathinfo($bannerPath, PATHINFO_EXTENSION))
                                            : '';
                                        $videoExtensions = ['mp4', 'webm', 'ogg', 'mov', 'avi'];
                                        $imageExtensions = [
                                            'jpeg',
                                            'png',
                                            'webp',
                                            'jpg',
                                            'gif',
                                            'svg',
                                            'svg+xml',
                                            'avif',
                                        ];

                                        $isVideo = $bannerPath && in_array($extension, $videoExtensions);
                                        $isImage = $bannerPath && in_array($extension, $imageExtensions);
                                    @endphp
                                    {{-- @dd($bannerPath, $isVideo, $isImage) --}}
                                    @if ($bannerPath)
                                        @if ($isVideo)
                                            <video src="{{ Storage::url($bannerPath) }}" autoplay muted loop
                                                class="w-full object-cover rounded-t-lg" style="height: 250px;"></video>
                                        @elseif ($isImage)
                                            <img src="{{ Storage::url($bannerPath) }}" alt="Shop Banner"
                                                class="w-full object-cover rounded-t-lg" style="height: 250px;">
                                        @else
                                            <img src="{{ asset('assets/img/header.jpg') }}" alt="Default Banner"
                                                class="w-full object-cover rounded-t-lg" style="height: 250px;">
                                        @endif
                                    @else
                                        <img src="{{ asset('assets/img/heaer.jpg') }}" alt="Default Banner"
                                            class="w-full object-cover rounded-t-lg" style="height: 250px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-6">
                            <div class="flex items-center space-x-4">
                                <div class="avatar-upload">
                                    @if ($shop && $shop->logo)
                                        <img src="{{ Storage::url($shop->logo) }}" alt="Profile"
                                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <img src="{{ asset('assets/img/heaer.jpg') }}" alt="Profile"
                                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                    @endif
                                </div>
                                <div class=" ms-6">
                                    <h1 class="text-2xl font-bold text-gray-900">{{ $shop->name }}
                                    </h1>
                                    <p class="text-gray-600">{{ $shop->email }}</p>
                                    <div class="flex items-center mt-1">
                                        <span
                                            class="inline-flex items-center py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                            <span
                                                class="w-2 h-2 bg-primary-400 rounded-full mr-1 status-indicator"></span>
                                            Vendor Profile
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Profile Completion</p>
                                    <div class="flex items-center space-x-2 justify-center mt-3">
                                        <div class="w-16 h-16 relative">
                                            <svg class="w-16 h-16 progress-ring" viewBox="0 0 64 64">
                                                <circle cx="32" cy="32" r="28" stroke="#e5e7eb"
                                                    stroke-width="4" fill="transparent" />
                                                <circle cx="32" cy="32" r="28" stroke="#3b82f6"
                                                    stroke-width="4" fill="transparent"
                                                    stroke-dasharray="{{ 2 * pi() * 28 }}"
                                                    stroke-dashoffset="{{ 2 * pi() * 28 * (1 - $profileCompletion / 100) }}"
                                                    class="progress-ring-circle" />
                                            </svg>
                                            <div class="absolute inset-0 flex items-center justify-center">
                                                <span
                                                    class="text-sm font-bold text-gray-900">{{ $profileCompletion }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div x-data="{ tab: 'personal' }"
                    class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mt-6">
                    <!-- Enhanced Tab Navigation -->
                    <div class="border-b border-gray-200 bg-gray-50">
                        <nav class="flex space-x-8 px-6" aria-label="Tabs">
                            <button @click="tab = 'personal'"
                                :class="tab === 'personal' ? 'border-primary-600 text-primary-600' :
                                    'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Shop Information
                                </div>
                            </button>
                            <button @click="tab = 'shop'"
                                :class="tab === 'shop' ? 'border-primary-600 text-primary-600' :
                                    'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Personal Information
                                </div>
                            </button>
                            <button @click="tab = 'security'"
                                :class="tab === 'security' ? 'border-primary-600 text-primary-600' :
                                    'border-transparent text-gray-500 hover:text-primary-600 hover:border-primary-600'"
                                class="py-4 px-1 border-b-2 font-medium text-sm transition">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Shop verification
                                </div>
                            </button>
                        </nav>
                    </div>

                    <!-- Enhanced Tab Content -->
                    <div class="p-6">
                        <div x-show="tab === 'personal'">
                            {{-- <form wire:submit="submit">
                            <div class="bg-gray-50 rounded-lg p-6">{{ $this->form }}</div>

                            <div class="flex justify-end mt-6">
                                <button type="submit"
                                    class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-primary-500 from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all duration-200 shadow-lg">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form> --}}

                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="data.shop-details">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--> <svg
                                            class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                            data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z">
                                            </path>
                                        </svg>
                                        <div class="grid flex-1 gap-y-1">
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                Shop Details
                                            </h3>
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                Basic information about the shop
                                            </p>
                                        </div>
                                    </div>
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                                <!--[if BLOCK]><![endif]-->
                                                <div>
                                                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                                                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="plyIDQ2pecrvY4BDDnM8.data.name.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.name">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Shop
                                                                                Name
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled" id="data.name"
                                                                                    maxlength="255"
                                                                                    placeholder="Enter shop name"
                                                                                    required="required" type="text"
                                                                                    wire:model.live="data.name">
                                                                            </div>
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="plyIDQ2pecrvY4BDDnM8.data.user_id.Filament\Forms\Components\Select">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.user_id">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Owner<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-select">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <!--[if BLOCK]><![endif]-->
                                                                                <div class="hidden"
                                                                                    x-data="{
                                                                                        isDisabled: true,
                                                                                        init: function() {
                                                                                            const container = $el.nextElementSibling
                                                                                            container.dispatchEvent(
                                                                                                new CustomEvent('set-select-property', {
                                                                                                    detail: { isDisabled: this.isDisabled },
                                                                                                }),
                                                                                            )
                                                                                        },
                                                                                    }">
                                                                                </div>
                                                                                <div x-load=""
                                                                                    x-load-src="http://sohoj_ecommerce.test/js/filament/forms/components/select.js?v=3.3.0.0"
                                                                                    x-data="selectFormComponent({
                                                                                        canSelectPlaceholder: true,
                                                                                        isHtmlAllowed: false,
                                                                                        getOptionLabelUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptionLabel('data.user_id')
                                                                                        },
                                                                                        getOptionLabelsUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptionLabels('data.user_id')
                                                                                        },
                                                                                        getOptionsUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptions('data.user_id')
                                                                                        },
                                                                                        getSearchResultsUsing: async (search) = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectSearchResults('data.user_id', search)
                                                                                        },
                                                                                        isAutofocused: false,
                                                                                        isMultiple: false,
                                                                                        isSearchable: true,
                                                                                        livewireId: 'plyIDQ2pecrvY4BDDnM8',
                                                                                        hasDynamicOptions: false,
                                                                                        hasDynamicSearchResults: true,
                                                                                        loadingMessage: 'Loading...',
                                                                                        maxItems: null,
                                                                                        maxItemsMessage: 'Only  can be selected.',
                                                                                        noSearchResultsMessage: 'No options match your search.',
                                                                                        options: [],
                                                                                        optionsLimit: 50,
                                                                                        placeholder: null,
                                                                                        position: null,
                                                                                        searchDebounce: 1000,
                                                                                        searchingMessage: 'Searching...',
                                                                                        searchPrompt: 'Start typing to search...',
                                                                                        searchableOptionFields: JSON.parse('[\u0022label\u0022]'),
                                                                                        state: $wire.$entangle('data.user_id', false),
                                                                                        statePath: 'data.user_id',
                                                                                    })"
                                                                                    wire:ignore=""
                                                                                    x-on:keydown.esc="select.dropdown.isActive &amp;&amp; $event.stopPropagation()"
                                                                                    x-on:set-select-property="$event.detail.isDisabled ? select.disable() : select.enable()"
                                                                                    class="">
                                                                                    <div class="choices is-disabled"
                                                                                        data-type="select-one"
                                                                                        tabindex="-1" role="combobox"
                                                                                        aria-autocomplete="list"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false"
                                                                                        aria-disabled="true">
                                                                                        <div class="choices__inner">
                                                                                            <select x-ref="input"
                                                                                                class="h-9 w-full rounded-lg border-none bg-transparent !bg-none choices__input"
                                                                                                disabled=""
                                                                                                id="data.user_id"
                                                                                                hidden=""
                                                                                                tabindex="-1"
                                                                                                data-choice="active">
                                                                                                <option value="10892"
                                                                                                    data-custom-properties="[object Object]">
                                                                                                    Royalit/option>
                                                                                            </select>
                                                                                            <div
                                                                                                class="choices__list choices__list--single">
                                                                                                <div class="choices__item choices__item--selectable"
                                                                                                    data-item=""
                                                                                                    data-id="1"
                                                                                                    data-value="10892"
                                                                                                    data-custom-properties="[object Object]"
                                                                                                    aria-selected="true"
                                                                                                    data-deletable="">
                                                                                                    Royalit<button
                                                                                                        type="button"
                                                                                                        class="choices__button"
                                                                                                        aria-label="Remove item: '10892'"
                                                                                                        data-button="">Remove
                                                                                                        item</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="choices__list choices__list--dropdown"
                                                                                            aria-expanded="false">
                                                                                            <input type="search"
                                                                                                name="search_terms"
                                                                                                class="choices__input choices__input--cloned"
                                                                                                autocomplete="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                role="textbox"
                                                                                                aria-autocomplete="list"
                                                                                                aria-label="null"
                                                                                                placeholder="Start typing to search..."
                                                                                                disabled="">
                                                                                            <div class="choices__list"
                                                                                                role="listbox">
                                                                                                <div id="choices--datauser_id-item-choice-1"
                                                                                                    class="choices__item choices__item--choice is-selected choices__item--selectable is-highlighted"
                                                                                                    role="option"
                                                                                                    data-choice=""
                                                                                                    data-id="1"
                                                                                                    data-value="10892"
                                                                                                    data-select-text=""
                                                                                                    data-choice-selectable=""
                                                                                                    aria-selected="true">
                                                                                                    Royalit</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--[if ENDBLOCK]><![endif]-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="plyIDQ2pecrvY4BDDnM8.data.email.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.email">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Email<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.email" maxlength="255"
                                                                                    placeholder="shop@email.com"
                                                                                    required="required" type="email"
                                                                                    wire:model="data.email">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="plyIDQ2pecrvY4BDDnM8.data.phone.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.phone">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Phone<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.phone" maxlength="20"
                                                                                    placeholder="e.g. +8801XXXXXXXXX"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.phone">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>

                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </section>

                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl bg-white shadow-sm mt-6 ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="data.descriptions">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--> <svg
                                            class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                            data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                                            </path>
                                        </svg> <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]-->
                                        <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                Descriptions
                                            </h3>
                                            <!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]-->
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                Detailed and short descriptions
                                            </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->



                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="tUNc3BIqjHLumfGKduS1.data.description.Filament\Forms\Components\Textarea">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="data.description">


                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                    Description<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </span>


                                                            </label>
                                                            <!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div
                                                                class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-textarea overflow-hidden">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                    <div wire:ignore.self="" style="">
                                                                        <textarea x-load="" x-load-src="http://sohoj_ecommerce.test/js/filament/forms/components/textarea.js?v=3.3.0.0"
                                                                            x-data="textareaFormComponent({
                                                                                initialHeight: 5.25,
                                                                                shouldAutosize: false,
                                                                                state: $wire.$entangle('data.description'),
                                                                            })" x-model="state"
                                                                            class="block h-full w-full border-none bg-transparent px-3 py-1.5 text-base text-gray-950 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6"
                                                                            disabled="disabled" id="data.description" placeholder="Full shop description" required="required"
                                                                            rows="3" wire:model="data.description"></textarea>
                                                                    </div>
                                                                </div>

                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="tUNc3BIqjHLumfGKduS1.data.short_description.Filament\Forms\Components\Textarea">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="data.short_description">


                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                    Short
                                                                    Description<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </span>


                                                            </label>
                                                            <!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div
                                                                class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-textarea overflow-hidden">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                    <div wire:ignore.self="" style="">
                                                                        <textarea x-load="" x-load-src="http://sohoj_ecommerce.test/js/filament/forms/components/textarea.js?v=3.3.0.0"
                                                                            x-data="textareaFormComponent({
                                                                                initialHeight: 3.75,
                                                                                shouldAutosize: false,
                                                                                state: $wire.$entangle('data.short_description'),
                                                                            })" x-model="state"
                                                                            class="block h-full w-full border-none bg-transparent px-3 py-1.5 text-base text-gray-950 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6"
                                                                            disabled="disabled" id="data.short_description" placeholder="Short summary for listings" required="required"
                                                                            rows="2" wire:model="data.short_description"></textarea>
                                                                    </div>
                                                                </div>

                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="tUNc3BIqjHLumfGKduS1.data.tags.Filament\Forms\Components\TagsInput">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="data.tags">


                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                    Tags<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </span>


                                                            </label>
                                                            <!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div
                                                                class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-tags-input">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                    <div x-load=""
                                                                        x-load-src="http://sohoj_ecommerce.test/js/filament/forms/components/tags-input.js?v=3.3.0.0"
                                                                        x-data="tagsInputFormComponent({
                                                                            state: $wire.$entangle('data.tags', false),
                                                                            splitKeys: [],
                                                                        })">
                                                                        <input
                                                                            class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                            autocomplete="off" disabled="disabled"
                                                                            id="data.tags"
                                                                            list="data.tags-suggestions"
                                                                            placeholder="Add tags" type="text"
                                                                            x-bind="input">

                                                                        <datalist id="data.tags-suggestions">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </datalist>

                                                                        <div
                                                                            class="[&amp;_.fi-badge-delete-button]:hidden">
                                                                            <div wire:ignore="">
                                                                                <template x-if="state?.length">
                                                                                    <div
                                                                                        class="fi-fo-tags-input-tags-ctn flex w-full flex-wrap gap-1.5 border-t border-t-gray-200 p-2 dark:border-t-white/10">
                                                                                        <template
                                                                                            x-for="(tag, index) in state"
                                                                                            x-bind:key="`${tag}-${index}`"
                                                                                            class="hidden">
                                                                                            <span
                                                                                                style="--c-50:var(--primary-50);--c-400:var(--primary-400);--c-600:var(--primary-600);"
                                                                                                class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-2 min-w-[theme(spacing.6)] py-1 fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30 fi-color-primary">


                                                                                                <span class="grid">
                                                                                                    <span
                                                                                                        class="truncate">
                                                                                                        <span
                                                                                                            x-text="tag"
                                                                                                            class="select-none text-start"></span>
                                                                                                    </span>
                                                                                                </span>

                                                                                                <button type="button"
                                                                                                    style="--c-300:var(--primary-300);--c-700:var(--primary-700);"
                                                                                                    class="fi-badge-delete-button -my-1 -me-2 -ms-1 flex items-center justify-center p-1 outline-none transition duration-75 text-custom-700/50 hover:text-custom-700/75 focus-visible:text-custom-700/75 dark:text-custom-300/50 dark:hover:text-custom-300/75 dark:focus-visible:text-custom-300/75"
                                                                                                    x-on:click.stop="deleteTag(tag)">
                                                                                                    <svg class="h-3.5 w-3.5"
                                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                                        viewBox="0 0 20 20"
                                                                                                        fill="currentColor"
                                                                                                        aria-hidden="true"
                                                                                                        data-slot="icon">
                                                                                                        <path
                                                                                                            d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z">
                                                                                                        </path>
                                                                                                    </svg>
                                                                                                </button>
                                                                                            </span>
                                                                                        </template>
                                                                                    </div>
                                                                                </template>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="tUNc3BIqjHLumfGKduS1.data.terms.Filament\Forms\Components\RichEditor">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="data.terms">
                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                                                    Terms &amp;
                                                                    Conditions
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div x-data="{
                                                                state: $wire.$entangle('data.terms', false),
                                                            }" x-html="state"
                                                                class="fi-fo-rich-editor fi-disabled prose block w-full max-w-none rounded-lg bg-gray-50 px-3 py-3 text-gray-500 shadow-sm ring-1 ring-gray-950/10 dark:prose-invert dark:bg-transparent dark:text-gray-400 dark:ring-white/10 sm:text-sm">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl mt-6 bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="data.company-information">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--> <svg
                                            class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                            data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21">
                                            </path>
                                        </svg> <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]-->
                                        <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                Company Information
                                            </h3>
                                            <!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]-->
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                Legal and company details
                                            </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->



                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                                <!--[if BLOCK]><![endif]-->
                                                <div>
                                                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                                                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="KBadjni0DWcwq4DepwEc.data.company_name.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.company_name">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Company
                                                                                Name<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.company_name"
                                                                                    maxlength="255"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.company_name">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="KBadjni0DWcwq4DepwEc.data.company_registration.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.company_registration">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Registration
                                                                                No.<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.company_registration"
                                                                                    maxlength="255"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.company_registration">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>

                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </section>

                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl mt-6 bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="data.location">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--> <svg
                                            class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                            data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z">
                                            </path>
                                        </svg> <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]-->
                                        <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                Location
                                            </h3>
                                            <!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]-->
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                Shop address details
                                            </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->



                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                                <!--[if BLOCK]><![endif]-->
                                                <div>
                                                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                                                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="4U80sFAQURhP36gmKAw8.data.city.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.city">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                City<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled" id="data.city"
                                                                                    maxlength="100"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.city">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="4U80sFAQURhP36gmKAw8.data.state.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.state">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                State<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.state" maxlength="100"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.state">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="4U80sFAQURhP36gmKAw8.data.post_code.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.post_code">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Post
                                                                                Code<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.post_code" maxlength="20"
                                                                                    type="text"
                                                                                    wire:model="data.post_code">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="4U80sFAQURhP36gmKAw8.data.country.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="data.country">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Country<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="data.country" maxlength="100"
                                                                                    required="required" type="text"
                                                                                    wire:model="data.country">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>

                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </section>
                        </div>
                        <div x-show="tab === 'shop'" x-cloak>
                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="mountedTableActionsData.0.user-information">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]-->
                                        <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                User Information
                                            </h3>
                                            <!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]-->
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                Basic details about the user.
                                            </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->



                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="mHyDiauKA5fnNhNiCb1o.mountedTableActionsData.0.name.Filament\Forms\Components\TextInput">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="mountedTableActionsData.0.name">


                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                    First
                                                                    Name<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </span>


                                                            </label>
                                                            <!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div
                                                                class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                    <input
                                                                        class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                        disabled="disabled"
                                                                        id="mountedTableActionsData.0.name"
                                                                        maxlength="255" required="required"
                                                                        type="text"
                                                                        value="{{ $shop->user->name }}">
                                                                </div>

                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>

                                            <div style="--col-span-default: span 1 / span 1;"
                                                class="col-[--col-span-default]"
                                                wire:key="mHyDiauKA5fnNhNiCb1o.mountedTableActionsData.0.l_name.Filament\Forms\Components\TextInput">
                                                <!--[if BLOCK]><![endif]-->
                                                <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                    <div class="grid gap-y-2">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="flex items-center gap-x-3 justify-between ">
                                                            <!--[if BLOCK]><![endif]--> <label
                                                                class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                for="mountedTableActionsData.0.l_name">


                                                                <span
                                                                    class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                    Last
                                                                    Name<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </span>


                                                            </label>
                                                            <!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]-->
                                                        <div class="grid auto-cols-fr gap-y-2">
                                                            <div
                                                                class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                    <input
                                                                        class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                        disabled="disabled"
                                                                        id="mountedTableActionsData.0.l_name"
                                                                        maxlength="255" type="text"
                                                                        value="{{ $shop->user->l_name }}">
                                                                </div>

                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>
                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                </div>

                                                <!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>

                                        <div style="--col-span-default: span 1 / span 1;"
                                            class="col-[--col-span-default] mt-3"
                                            wire:key="mHyDiauKA5fnNhNiCb1o.mountedTableActionsData.0.email.Filament\Forms\Components\TextInput">
                                            <!--[if BLOCK]><![endif]-->
                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                <div class="grid gap-y-2">
                                                    <!--[if BLOCK]><![endif]-->
                                                    <div class="flex items-center gap-x-3 justify-between ">
                                                        <!--[if BLOCK]><![endif]--> <label
                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                            for="mountedTableActionsData.0.email">


                                                            <span
                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                Email<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                            </span>


                                                        </label>
                                                        <!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <!--[if ENDBLOCK]><![endif]-->

                                                    <!--[if BLOCK]><![endif]-->
                                                    <div class="grid auto-cols-fr gap-y-2">
                                                        <div
                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                            <div class="fi-input-wrp-input min-w-0 flex-1">
                                                                <input
                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                    disabled="disabled"
                                                                    id="mountedTableActionsData.0.email"
                                                                    required="required" type="email"
                                                                    value="{{ $shop->user->email }}">
                                                            </div>

                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <!--[if ENDBLOCK]><![endif]-->
                                                </div>
                                            </div>

                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </section>

                        </div>
                        <div x-show="tab === 'security'" x-cloak>
                            <section x-data="{
                                isCollapsed: false,
                            }"
                                class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
                                id="mountedTableActionsData.0.user-contact">
                                <!--[if BLOCK]><![endif]-->
                                <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <!--[if BLOCK]><![endif]--> <svg
                                            class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true"
                                            data-slot="icon">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z">
                                            </path>
                                        </svg> <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]-->
                                        <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->
                                            <h3
                                                class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                                                User &amp; Contact
                                            </h3>
                                            <!--[if ENDBLOCK]><![endif]-->

                                            <!--[if BLOCK]><![endif]-->
                                            <p
                                                class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                                                User selection and contact details
                                            </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->

                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->



                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </header>
                                <!--[if ENDBLOCK]><![endif]-->

                                <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                                    <div class="fi-section-content p-6">
                                        <div style="--cols-default: repeat(1, minmax(0, 1fr));"
                                            class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                                            <!--[if BLOCK]><![endif]-->
                                            <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                                                <!--[if BLOCK]><![endif]-->
                                                <div>
                                                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));"
                                                        class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                                                        <!--[if BLOCK]><![endif]-->
                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.user_id.Filament\Forms\Components\Select">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="mountedTableActionsData.0.user_id">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                User<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-select">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <!--[if BLOCK]><![endif]-->
                                                                                <div class="hidden"
                                                                                    x-data="{
                                                                                        isDisabled: true,
                                                                                        init: function() {
                                                                                            const container = $el.nextElementSibling
                                                                                            container.dispatchEvent(
                                                                                                new CustomEvent('set-select-property', {
                                                                                                    detail: { isDisabled: this.isDisabled },
                                                                                                }),
                                                                                            )
                                                                                        },
                                                                                    }">
                                                                                </div>
                                                                                <div x-load=""
                                                                                    x-load-src="http://sohoj_ecommerce.test/js/filament/forms/components/select.js?v=3.3.0.0"
                                                                                    x-data="selectFormComponent({
                                                                                        canSelectPlaceholder: true,
                                                                                        isHtmlAllowed: false,
                                                                                        getOptionLabelUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptionLabel('mountedTableActionsData.0.user_id')
                                                                                        },
                                                                                        getOptionLabelsUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptionLabels('mountedTableActionsData.0.user_id')
                                                                                        },
                                                                                        getOptionsUsing: async () = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectOptions('mountedTableActionsData.0.user_id')
                                                                                        },
                                                                                        getSearchResultsUsing: async (search) = & gt;
                                                                                        {
                                                                                            return await $wire.getFormSelectSearchResults('mountedTableActionsData.0.user_id', search)
                                                                                        },
                                                                                        isAutofocused: false,
                                                                                        isMultiple: false,
                                                                                        isSearchable: true,
                                                                                        livewireId: 'oMGe5Tm7arpG0lFWsXvb',
                                                                                        hasDynamicOptions: false,
                                                                                        hasDynamicSearchResults: true,
                                                                                        loadingMessage: 'Loading...',
                                                                                        maxItems: null,
                                                                                        maxItemsMessage: 'Only  can be selected.',
                                                                                        noSearchResultsMessage: 'No options match your search.',
                                                                                        options: [],
                                                                                        optionsLimit: 50,
                                                                                        placeholder: null,
                                                                                        position: null,
                                                                                        searchDebounce: 1000,
                                                                                        searchingMessage: 'Searching...',
                                                                                        searchPrompt: 'Start typing to search...',
                                                                                        searchableOptionFields: JSON.parse('[\u0022label\u0022]'),
                                                                                        state: $wire.$entangle('mountedTableActionsData.0.user_id', false),
                                                                                        statePath: 'mountedTableActionsData.0.user_id',
                                                                                    })"
                                                                                    wire:ignore=""
                                                                                    x-on:keydown.esc="select.dropdown.isActive &amp;&amp; $event.stopPropagation()"
                                                                                    x-on:set-select-property="$event.detail.isDisabled ? select.disable() : select.enable()"
                                                                                    class="">
                                                                                    <div class="choices is-disabled"
                                                                                        data-type="select-one"
                                                                                        tabindex="-1" role="combobox"
                                                                                        aria-autocomplete="list"
                                                                                        aria-haspopup="true"
                                                                                        aria-expanded="false"
                                                                                        aria-disabled="true">
                                                                                        <div class="choices__inner">
                                                                                            <select x-ref="input"
                                                                                                class="h-9 w-full rounded-lg border-none bg-transparent !bg-none choices__input"
                                                                                                disabled=""
                                                                                                id="mountedTableActionsData.0.user_id"
                                                                                                hidden=""
                                                                                                tabindex="-1"
                                                                                                data-choice="active">
                                                                                                <option value="10899"
                                                                                                    data-custom-properties="[object Object]">
                                                                                                    Vendor</option>
                                                                                            </select>
                                                                                            <div
                                                                                                class="choices__list choices__list--single">
                                                                                                <div class="choices__item choices__item--selectable"
                                                                                                    data-item=""
                                                                                                    data-id="1"
                                                                                                    data-value="10899"
                                                                                                    data-custom-properties="[object Object]"
                                                                                                    aria-selected="true"
                                                                                                    data-deletable="">
                                                                                                    Vendor<button
                                                                                                        type="button"
                                                                                                        class="choices__button"
                                                                                                        aria-label="Remove item: '10899'"
                                                                                                        data-button="">Remove
                                                                                                        item</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="choices__list choices__list--dropdown"
                                                                                            aria-expanded="false">
                                                                                            <input type="search"
                                                                                                name="search_terms"
                                                                                                class="choices__input choices__input--cloned"
                                                                                                autocomplete="off"
                                                                                                autocapitalize="off"
                                                                                                spellcheck="false"
                                                                                                role="textbox"
                                                                                                aria-autocomplete="list"
                                                                                                aria-label="null"
                                                                                                placeholder="Start typing to search..."
                                                                                                disabled="">
                                                                                            <div class="choices__list"
                                                                                                role="listbox">
                                                                                                <div id="choices--mountedTableActionsData0user_id-item-choice-1"
                                                                                                    class="choices__item choices__item--choice is-selected choices__item--selectable is-highlighted"
                                                                                                    role="option"
                                                                                                    data-choice=""
                                                                                                    data-id="1"
                                                                                                    data-value="10899"
                                                                                                    data-select-text=""
                                                                                                    data-choice-selectable=""
                                                                                                    aria-selected="true">
                                                                                                    Vendor</div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!--[if ENDBLOCK]><![endif]-->
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.phone.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="mountedTableActionsData.0.phone">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Phone
                                                                                Number<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="mountedTableActionsData.0.phone"
                                                                                    placeholder="e.g. +8801XXXXXXXXX"
                                                                                    required="required" type="text"
                                                                                    value="{{ $shop->user->verification->phone }}">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.paypal_email.Filament\Forms\Components\TextInput">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="mountedTableActionsData.0.paypal_email">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                PayPal
                                                                                Email<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="mountedTableActionsData.0.paypal_email"
                                                                                    placeholder="user@email.com"
                                                                                    required="required" type="email"
                                                                                    value="{{ $shop->user->verification->paypal_email }}">
                                                                            </div>

                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                            </div>

                                                            <!--[if ENDBLOCK]><![endif]-->
                                                        </div>

                                                        <div style="--col-span-default: span 1 / span 1;"
                                                            class="col-[--col-span-default]"
                                                            wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.dob.Filament\Forms\Components\DatePicker">
                                                            <!--[if BLOCK]><![endif]-->
                                                            <div data-field-wrapper="" class="fi-fo-field-wrp">
                                                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                <div class="grid gap-y-2">
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div
                                                                        class="flex items-center gap-x-3 justify-between ">
                                                                        <!--[if BLOCK]><![endif]--> <label
                                                                            class="fi-fo-field-wrp-label inline-flex items-center gap-x-3"
                                                                            for="mountedTableActionsData.0.dob">


                                                                            <span
                                                                                class="text-sm font-medium leading-6 text-gray-950 dark:text-white">

                                                                                Date of
                                                                                Birth<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            </span>


                                                                        </label>
                                                                        <!--[if ENDBLOCK]><![endif]-->

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>
                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                    {{-- @dd($shop->user->verification->dob) --}}
                                                                    <!--[if BLOCK]><![endif]-->
                                                                    <div class="grid auto-cols-fr gap-y-2">
                                                                        <div
                                                                            class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
                                                                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                            @php
                                                                                $dob = $shop->user->verification->dob;
                                                                            @endphp
                                                                            <div
                                                                                class="fi-input-wrp-input min-w-0 flex-1">
                                                                                <!--[if BLOCK]><![endif]--> <input
                                                                                    class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3"
                                                                                    disabled="disabled"
                                                                                    id="mountedTableActionsData.0.dob"
                                                                                    required="required" type="date"
                                                                                    value="{{ $dob ? \Carbon\Carbon::parse($dob)->format('Y-m-d') : '' }}"
                                                                                    <!--[if ENDBLOCK]><![endif]-->
                                                                        </div>

                                                                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                    </div>

                                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                                                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                                                </div>
                                                                <!--[if ENDBLOCK]><![endif]-->
                                                            </div>
                                                        </div>

                                                        <!--[if ENDBLOCK]><![endif]-->
                                                    </div>
                                                    <!--[if ENDBLOCK]><![endif]-->
                                                </div>

                                            </div>

                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>

                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </section>

                        <section x-data="{
                            isCollapsed: false,
                        }" class="fi-section rounded-xl mt-6 bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" id="mountedTableActionsData.0.identification">
                        <!--[if BLOCK]><![endif]-->        <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <!--[if BLOCK]><![endif]-->                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"></path>
                    </svg>                <!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]-->                    <div class="grid flex-1 gap-y-1">
                                            <!--[if BLOCK]><![endif]-->                            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Identification
                    </h3>
                                            <!--[if ENDBLOCK]><![endif]-->
                    
                                            <!--[if BLOCK]><![endif]-->                            <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                        Government and card identification
                    </p>
                                            <!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    <!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                                    
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                    
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </header>
                        <!--[if ENDBLOCK]><![endif]-->
                    
                        <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                            <div class="fi-section-content p-6">
                                <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                        <!--[if BLOCK]><![endif]-->
                            <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                        <!--[if BLOCK]><![endif]-->                <div>
                        <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                        <!--[if BLOCK]><![endif]-->
                            <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.tax_no.Filament\Forms\Components\TextInput">
                        <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                        <div class="grid gap-y-2">
                            <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                    <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.tax_no">
                        
                    
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            
                            Tax Number<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                        </span>
                    
                        
                    </label>
                                    <!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <!--[if ENDBLOCK]><![endif]-->
                    
                            <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                    <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                        <div class="fi-input-wrp-input min-w-0 flex-1">
                            <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.tax_no" required="required" type="text" value="{{ $shop->user->verification->tax_no }}">
                        </div>
                    
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    
                          {{-- @dd($shop->user->verification)      <!--[if ENDBLOCK]><![endif]--> --}}
                    </div>
                                
                            <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.card_no.Filament\Forms\Components\TextInput">
                        <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                        <div class="grid gap-y-2">
                            <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                    <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.card_no">
                        
                    
                        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                            
                            Card Number<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                        </span>
                    
                        
                    </label>
                                    <!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <!--[if ENDBLOCK]><![endif]-->
                    
                            <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                    <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                        <div class="fi-input-wrp-input min-w-0 flex-1">
                            <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.card_no" required="required" type="text" value="{{ $shop->user->verification->card_no }}">
                        </div>
                    
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    
                                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            <!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    
                                <!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div class="flex">
                        @if ($shop->user->verification->govt_id_back)
<div class="" style="height: 180px">
                            <img src="{{ Storage::url($shop->user->verification->govt_id_back) }}" alt="">
                        </div>
@endif

                        @if ($shop->user->verification->govt_id_front)
<div class="" style="height: 180px">
                            <img src="{{ Storage::url($shop->user->verification->govt_id_front) }}" alt="">
                        </div>
@endif
                    </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                    
                    </div>
                    
                                <!--[if ENDBLOCK]><![endif]-->
                    </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                            </div>
                    
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </section>


                    <section x-data="{
                        isCollapsed: false,
                    }" class="fi-section rounded-xl mt-6 bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" id="mountedTableActionsData.0.bank-details">
                    <!--[if BLOCK]><![endif]-->        <header class="fi-section-header flex flex-col gap-3 px-6 py-4">
                            <div class="flex items-center gap-3">
                                <!--[if BLOCK]><![endif]-->                    <svg class="fi-section-header-icon self-start text-gray-400 dark:text-gray-500 fi-color-{$iconColor} h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
                </svg>                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]-->                    <div class="grid flex-1 gap-y-1">
                                        <!--[if BLOCK]><![endif]-->                            <h3 class="fi-section-header-heading text-base font-semibold leading-6 text-gray-950 dark:text-white">
                    Bank Details
                </h3>
                                        <!--[if ENDBLOCK]><![endif]-->
                
                                        <!--[if BLOCK]><![endif]-->                            <p class="fi-section-header-description overflow-hidden break-words text-sm text-gray-500 dark:text-gray-400">
                    Bank account and routing information
                </p>
                                        <!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                        </header>
                    <!--[if ENDBLOCK]><![endif]-->
                
                    <div class="fi-section-content-ctn border-t border-gray-200 dark:border-white/10">
                        <div class="fi-section-content p-6">
                            <div style="--cols-default: repeat(1, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] fi-fo-component-ctn gap-6">
                    <!--[if BLOCK]><![endif]-->
                        <div style="--col-span-default: 1 / -1;" class="col-[--col-span-default]">
                    <!--[if BLOCK]><![endif]-->                <div>
                    <div style="--cols-default: repeat(1, minmax(0, 1fr)); --cols-lg: repeat(2, minmax(0, 1fr));" class="grid grid-cols-[--cols-default] lg:grid-cols-[--cols-lg] fi-fo-component-ctn gap-6">
                    <!--[if BLOCK]><![endif]-->
                        <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.bank_ac.Filament\Forms\Components\TextInput">
                    <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="grid gap-y-2">
                        <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.bank_ac">
                    
                
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        
                        Bank Account<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </span>
                
                    
                </label>
                                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                
                        <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="fi-input-wrp-input min-w-0 flex-1">
                        <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.bank_ac" required="required" type="text" value="{{ $shop->user->verification->bank_ac }}">
                    </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                
                            <!--[if ENDBLOCK]><![endif]-->
                </div>
                            
                        <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.ac_holder_name.Filament\Forms\Components\TextInput">
                    <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="grid gap-y-2">
                        <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.ac_holder_name">
                    
                
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        
                        Account Holder Name<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </span>
                
                    
                </label>
                                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                
                        <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="fi-input-wrp-input min-w-0 flex-1">
                        <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.ac_holder_name" required="required" type="text" value="{{ $shop->user->verification->ac_holder_name }}">
                    </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                
                            <!--[if ENDBLOCK]><![endif]-->
                </div>
                            
                        <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.address.Filament\Forms\Components\TextInput">
                    <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="grid gap-y-2">
                        <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.address">
                    
                
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        
                        Address<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </span>
                
                    
                </label>
                                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                
                        <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="fi-input-wrp-input min-w-0 flex-1">
                        <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.address" required="required" type="text" value="{{ $shop->user->verification->address }}">
                    </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                
                            <!--[if ENDBLOCK]><![endif]-->
                </div>
                            
                        <div style="--col-span-default: span 1 / span 1;" class="col-[--col-span-default]" wire:key="oMGe5Tm7arpG0lFWsXvb.mountedTableActionsData.0.rtn.Filament\Forms\Components\TextInput">
                    <!--[if BLOCK]><![endif]-->                <div data-field-wrapper="" class="fi-fo-field-wrp">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="grid gap-y-2">
                        <!--[if BLOCK]><![endif]-->            <div class="flex items-center gap-x-3 justify-between ">
                                <!--[if BLOCK]><![endif]-->                    <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="mountedTableActionsData.0.rtn">
                    
                
                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                        
                        Routing Number<!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </span>
                
                    
                </label>
                                <!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                
                        <!--[if BLOCK]><![endif]-->            <div class="grid auto-cols-fr gap-y-2">
                                <div class="fi-input-wrp flex rounded-lg shadow-sm ring-1 transition duration-75 fi-disabled bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10 fi-fo-text-input overflow-hidden">
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                    <div class="fi-input-wrp-input min-w-0 flex-1">
                        <input class="fi-input block w-full border-none py-1.5 text-base text-gray-950 transition duration-75 placeholder:text-gray-400 focus:ring-0 disabled:text-gray-500 disabled:[-webkit-text-fill-color:theme(colors.gray.500)] disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.400)] dark:text-white dark:placeholder:text-gray-500 dark:disabled:text-gray-400 dark:disabled:[-webkit-text-fill-color:theme(colors.gray.400)] dark:disabled:placeholder:[-webkit-text-fill-color:theme(colors.gray.500)] sm:text-sm sm:leading-6 bg-white/0 ps-3 pe-3" disabled="disabled" id="mountedTableActionsData.0.rtn" required="required" type="text" value="{{ $shop->user->verification->rtn }}">
                    </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                </div>
                
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                
                                <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        <!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                
                            <!--[if ENDBLOCK]><![endif]-->
                </div>
                    <!--[if ENDBLOCK]><![endif]-->
                </div>
                
                </div>
                
                            <!--[if ENDBLOCK]><![endif]-->
                </div>
                    <!--[if ENDBLOCK]><![endif]-->
                </div>
                        </div>
                
                        <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </section>

                
                    </div>
                    <form action="{{ route('shop_status_update', $shop->id) }}" method="POST">
                        @csrf
                        <div>
                            @if ($shop->status == 1)
<button type="submit" name="status" value="deactivate"
                                    class="border px-3.5 py-1.5 rounded-lg mt-3"
                                    style="background: rgb(255, 0, 0); color: #ffff;">
                                    Deactivate
                                </button>
@else
<button type="submit" name="status" value="activate"
                                    class="border px-3.5 py-1.5 rounded-lg mt-3"
                                    style="background: seagreen; color: #ffff;">
                                    Activate
                                </button>
@endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Close max-w-7xl container -->
    </div>
    <!-- Close min-h-screen container -->
</div>
<!-- Close root wrapper -->

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bannerInput = document.getElementById('banner-upload');
            const logoInput = document.getElementById('logo-upload');

            bannerInput.addEventListener('change', function() {
                this.closest('form').submit();
            });

            logoInput.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    </script>
@endpush
</x-filament-panels::page>
