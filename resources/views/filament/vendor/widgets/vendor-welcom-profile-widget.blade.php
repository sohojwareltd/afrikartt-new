<x-filament-widgets::widget>
    <x-filament::card>
        <div class="text-center space-y-4">
            <!-- Welcome header -->
            <div class="space-y-2">
                <h2 class="text-lg font-medium text-gray-900">
                    Welcome, {{ auth()->user()->name }}!
                </h2>
                <p class="text-sm text-gray-600">
                    Your profile has been submitted successfully.
                </p>
            </div>

            <!-- Status indicator -->
            <div class="inline-flex items-center space-x-2 px-3 py-2 bg-amber-50 text-amber-700 rounded-lg text-sm">
                <div class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></div>
                <span>Verification in Progress</span>
            </div>

            <!-- Info text -->
            <p class="text-xs text-gray-500">
                We're reviewing your information. This usually takes 24-48 hours.
            </p>

            <!-- Action button -->
            <x-filament::button 
                tag="a" 
                href="{{ route('filament.vendor.pages.dashboard') }}"
                size="sm"
            >
                Go to Dashboard
            </x-filament::button>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>



