<x-filament-widgets::widget>
    <x-filament::section>
        <div class="text-center space-y-4">
            <!-- Icon -->
            <div class="mx-auto w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-lg font-semibold text-gray-900">
                Complete Your Profile
            </h3>
            
            <!-- Description -->
            <p class="text-sm text-gray-600 max-w-md mx-auto">
                Set up your seller profile to start managing products and receiving orders.
            </p>
            
            <!-- Button -->
            <div class="pt-2">
                <x-filament::button 
                    tag="a" 
                    href="{{ route('filament.vendor.pages.vendor-profile-page') }}"
                    size="sm"
                    color="primary"
                >
                    Get Started
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
