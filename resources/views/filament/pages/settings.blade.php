<x-filament::page>
    @php
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
    @endphp
    
    <x-filament::section>
        <x-slot name="heading">
            Settings
        </x-slot>

        <div x-data="{ tab: 'general' }">
            {{-- Tab Navigation --}}
            <div class="mb-8">
                <nav class="flex space-x-2 bg-gray-100 dark:bg-gray-800 rounded-lg p-1 shadow-inner" aria-label="Tabs">
                    <button
                        @click="tab = 'general'"
                        :class="tab === 'general' 
                            ? 'bg-primary-600 text-white shadow-lg font-bold scale-105' 
                            : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700'"
                        class="px-6 py-2 rounded-lg transition-all duration-200 focus:outline-none"
                    >
                        General
                    </button>
                    <button
                        @click="tab = 'payment'"
                        :class="tab === 'payment' 
                            ? 'bg-primary-600 text-white shadow-lg font-bold scale-105' 
                            : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700'"
                        class="px-6 py-2 rounded-lg transition-all duration-200 focus:outline-none"
                    >
                        Payment
                    </button>
                    <button
                        @click="tab = 'admin'"
                        :class="tab === 'admin' 
                            ? 'bg-primary-600 text-white shadow-lg font-bold scale-105' 
                            : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700'"
                        class="px-6 py-2 rounded-lg transition-all duration-200 focus:outline-none"
                    >
                        Admin
                    </button>
                    <button
                        @click="tab = 'social'"
                        :class="tab === 'social' 
                            ? 'bg-primary-600 text-white shadow-lg font-bold scale-105' 
                            : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700'"
                        class="px-6 py-2 rounded-lg transition-all duration-200 focus:outline-none"
                    >
                        Social
                    </button>
                    {{-- <button
                        @click="tab = 'offer'"
                        :class="tab === 'offer' 
                            ? 'bg-primary-600 text-white shadow-lg font-bold scale-105' 
                            : 'text-gray-700 dark:text-gray-300 hover:bg-primary-50 dark:hover:bg-primary-900 hover:text-primary-700'"
                        class="px-6 py-2 rounded-lg transition-all duration-200 focus:outline-none"
                    >
                        Offer
                    </button> --}}
                </nav>
            </div>

            <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf

                {{-- General Tab --}}
                <div x-show="tab === 'general'" x-cloak class="space-y-6 mt-6">
                    @include('filament.pages.settings.general', ['settings' => $settings])
                </div>
                <div x-show="tab === 'payment'" x-cloak class="space-y-6 mt-6">
                    @include('filament.pages.settings.payment', ['settings' => $settings])
                </div>

                {{-- Admin Tab --}}
                <div x-show="tab === 'admin'" x-cloak class="space-y-6 mt-6">
                    @include('filament.pages.settings.admin', ['settings' => $settings])
                </div>

                {{-- Social Tab --}}
                <div x-show="tab === 'social'" x-cloak class="space-y-6 mt-6">
                    @include('filament.pages.settings.social', ['settings' => $settings])
                </div>

                {{-- Offer Tab --}}
                {{-- <div x-show="tab === 'offer'" x-cloak class="space-y-6 mt-6">
                    @include('filament.pages.settings.offer', ['settings' => $settings])
                </div> --}}

                <div class="mt-6">
                    <x-filament::button type="submit">
                        {{ __('Save Settings') }}
                    </x-filament::button>
                </div>
            </form>
        </div>
    </x-filament::section>

    <script>
        function handleFileDrop(event, inputId) {
            const files = event.dataTransfer.files;
            if (files.length > 0) {
                const input = document.getElementById(inputId);
                input.files = files;
                input.dispatchEvent(new Event('change'));
            }
        }
    </script>
</x-filament::page>
