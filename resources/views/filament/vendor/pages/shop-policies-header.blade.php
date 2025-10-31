<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden mb-6 transition-colors duration-200">
    <!-- Theme Toggle Button -->
    <div class="absolute top-4 right-4 z-10">
        <button id="theme-toggle" 
                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 group">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5 text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <!-- Header Section -->
    <div class="bg-gradient-to-r from-primary-50 to-primary-100 dark:from-gray-700 dark:to-gray-600 px-6 py-5 border-b border-gray-200 dark:border-gray-600 transition-colors duration-200 relative">
        <div class="flex items-center">
            <div class="flex-shrink-0 mr-4">
                @if (isset(auth()->user()->shop->logo) && auth()->user()->shop->logo)
                    <img src="{{ Storage::url(auth()->user()->shop->logo) }}" alt="Shop Logo"
                        class="w-16 h-16 rounded-full object-cover border-2 border-white dark:border-gray-300 shadow-sm">
                @else
                    <div class="w-16 h-16 rounded-full bg-white dark:bg-gray-200 flex items-center justify-center text-primary-600 dark:text-primary-700 border-2 border-white dark:border-gray-300 shadow-sm transition-colors duration-200">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 flex items-center transition-colors duration-200">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 mr-3 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    {{ $shop->name ?? 'Shop Policies' }}
                </h2>
                <p class="text-gray-600 dark:text-gray-300 mt-1 text-sm transition-colors duration-200">
                    {{ $shop->description ?? "Manage your shop's policies to ensure clear communication with customers." }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="p-6 dark:bg-gray-800 transition-colors duration-200">
        <form action="{{ route('vendor.shopPolicy.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Delivery Policy -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors duration-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 transition-colors duration-200">Delivery Policy</h3>
                    </div>
                    <textarea id="delivery" name="delivery" rows="4"
                        class="w-full px-4 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-all duration-200 @error('delivery') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Describe your delivery timelines, areas covered, and any shipping fees...">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->delivery : '' }}</textarea>
                    @error('delivery')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Payment Options -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors duration-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 transition-colors duration-200">Payment Options</h3>
                    </div>
                    <textarea id="payment_option" name="payment_option" rows="4"
                        class="w-full px-4 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-all duration-200 @error('payment_option') border-red-500 dark:border-red-400 @enderror"
                        placeholder="List all accepted payment methods (credit cards, PayPal, bank transfer, etc.)...">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->payment_option : '' }}</textarea>
                    @error('payment_option')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Return & Exchange -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors duration-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 transition-colors duration-200">Return & Exchange Policy</h3>
                    </div>
                    <textarea id="return_exchange" name="return_exchange" rows="4"
                        class="w-full px-4 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-all duration-200 @error('return_exchange') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Explain your return window, conditions for returns, and exchange process...">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->return_exchange : '' }}</textarea>
                    @error('return_exchange')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cancellation Policy -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 transition-colors duration-200">
                    <div class="flex items-center mb-3">
                        <svg class="w-5 h-5 text-primary-600 dark:text-primary-400 mr-2 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100 transition-colors duration-200">Cancellation Policy</h3>
                    </div>
                    <textarea id="cancellation" name="cancellation" rows="4"
                        class="w-full px-4 py-3 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-600 border border-gray-300 dark:border-gray-500 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-primary-400 focus:border-transparent transition-all duration-200 @error('cancellation') border-red-500 dark:border-red-400 @enderror"
                        placeholder="Specify your order cancellation policy, including deadlines and any fees...">{{ auth()->user()->shop->shopPolicy ? auth()->user()->shop->shopPolicy->cancellation : '' }}</textarea>
                    @error('cancellation')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 hover:bg-primary-700 dark:bg-primary-500 dark:hover:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-primary-400 dark:ring-offset-gray-800 transition-all duration-200">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save All Policies
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Theme Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const themeToggleBtn = document.getElementById('theme-toggle');
    const darkIcon = document.getElementById('theme-toggle-dark-icon');
    const lightIcon = document.getElementById('theme-toggle-light-icon');
    
    // Get theme from localStorage or default to light
    const currentTheme = localStorage.getItem('theme') || 'light';
    
    // Function to update theme
    function updateTheme(theme) {
        const html = document.documentElement;
        
        if (theme === 'dark') {
            html.classList.add('dark');
            darkIcon.classList.add('hidden');
            lightIcon.classList.remove('hidden');
            localStorage.setItem('theme', 'dark');
        } else {
            html.classList.remove('dark');
            lightIcon.classList.add('hidden');
            darkIcon.classList.remove('hidden');
            localStorage.setItem('theme', 'light');
        }
    }
    
    // Initialize theme
    updateTheme(currentTheme);
    
    // Theme toggle click handler
    themeToggleBtn.addEventListener('click', function() {
        const currentTheme = localStorage.getItem('theme') || 'light';
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        updateTheme(newTheme);
        
        // Add smooth animation feedback
        themeToggleBtn.classList.add('scale-95');
        setTimeout(() => {
            themeToggleBtn.classList.remove('scale-95');
        }, 100);
    });
    
    // Auto-detect system preference if no theme is set
    if (!localStorage.getItem('theme')) {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        updateTheme(prefersDark ? 'dark' : 'light');
    }
    
    // Listen for system theme changes
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
        if (!localStorage.getItem('theme')) {
            updateTheme(e.matches ? 'dark' : 'light');
        }
    });
});
</script>

<style>
/* Smooth transitions for theme switching */
* {
    transition-property: background-color, border-color, color, fill, stroke;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 200ms;
}

/* Custom scrollbar for dark mode */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

::-webkit-scrollbar-track {
    background: theme('colors.gray.100');
}

.dark ::-webkit-scrollbar-track {
    background: theme('colors.gray.700');
}

::-webkit-scrollbar-thumb {
    background: theme('colors.gray.300');
    border-radius: 4px;
}

.dark ::-webkit-scrollbar-thumb {
    background: theme('colors.gray.500');
}

::-webkit-scrollbar-thumb:hover {
    background: theme('colors.gray.400');
}

.dark ::-webkit-scrollbar-thumb:hover {
    background: theme('colors.gray.400');
}

/* Enhanced focus states for better accessibility */
.dark textarea:focus {
    box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Smooth button hover effects */
button {
    transition: all 0.2s ease-in-out;
}

button:hover {
    transform: translateY(-1px);
}

button:active {
    transform: translateY(0);
}
</style>