{{-- Payment Methods Configuration --}}
<div class="space-y-6">
    <!-- PayPal Configuration -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">PayPal Configuration</h3>
            <div class="space-y-2">
                <label for="paypal_enabled" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    PayPal Status
                </label>
                <select name="paypal_enabled" id="paypal_enabled"
                    class="w-32 rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                           focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                           dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    <option value="0" {{ old('paypal_enabled', $settings['paypal_enabled'] ?? 0) == 0 ? 'selected' : '' }}>Disabled</option>
                    <option value="1" {{ old('paypal_enabled', $settings['paypal_enabled'] ?? 0) == 1 ? 'selected' : '' }}>Enabled</option>
                </select>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="space-y-2">
                <label for="site_client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    PayPal Client ID
                </label>
                <input type="text" id="paypal_client_id" name="paypal_client_id"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
                    placeholder="Your PayPal Client ID" value="{{ old('paypal_client_id', $settings['paypal_client_id'] ?? '') }}" />
                <p class="text-xs text-gray-500 dark:text-gray-400">Enter your PayPal client ID</p>
            </div>

            <div class="space-y-2">
                <label for="paypal_secret_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    PayPal Secret ID
                </label>
                <input type="text" id="paypal_secret_id" name="paypal_secret_id"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
                    placeholder="Your PayPal Secret ID"
                    value="{{ old('paypal_secret_id', $settings['paypal_secret_id'] ?? '') }}" />
                <p class="text-xs text-gray-500 dark:text-gray-400">Enter your PayPal secret</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <label for="paypal_sandbox" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        PayPal Mode
                    </label>
                    <select name="paypal_sandbox" id="paypal_sandbox"
                        class="w-32 rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        <option value="1" {{ old('paypal_sandbox', $settings['paypal_sandbox'] ?? 1) == 1 ? 'selected' : '' }}>Sandbox</option>
                        <option value="0" {{ old('paypal_sandbox', $settings['paypal_sandbox'] ?? 1) == 0 ? 'selected' : '' }}>Live</option>
                    </select>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">Sandbox for testing, Live for production</span>
            </div>
        </div>
    </div>

    <!-- Stripe Configuration -->
    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Stripe Configuration</h3>
            <div class="space-y-2">
                <label for="stripe_enabled" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Stripe Status
                </label>
                <select name="stripe_enabled" id="stripe_enabled"
                    class="w-32 rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                           focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                           dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                    <option value="0" {{ old('stripe_enabled', $settings['stripe_enabled'] ?? 0) == 0 ? 'selected' : '' }}>Disabled</option>
                    <option value="1" {{ old('stripe_enabled', $settings['stripe_enabled'] ?? 0) == 1 ? 'selected' : '' }}>Enabled</option>
                </select>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="space-y-2">
                <label for="stripe_publishable_key" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Stripe Publishable Key
                </label>
                <input type="text" id="stripe_key" name="stripe_key"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
                    placeholder="pk_test_..." value="{{ old('stripe_key', $settings['stripe_key'] ?? '') }}" />
                <p class="text-xs text-gray-500 dark:text-gray-400">Enter your Stripe publishable key</p>
            </div>

            <div class="space-y-2">
                <label for="stripe_secret" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Stripe Secret Key
                </label>
                <input type="text" id="stripe_secret" name="stripe_secret"
                    class="w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
                    placeholder="sk_test_..." value="{{ old('stripe_secret', $settings['stripe_secret'] ?? '') }}" />
                <p class="text-xs text-gray-500 dark:text-gray-400">Enter your Stripe secret key</p>
            </div>

            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <label for="stripe_sandbox" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Stripe Mode
                    </label>
                    <select name="stripe_mode" id="stripe_mode"
                        class="w-32 rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm 
                               focus:border-primary-500 focus:ring-1 focus:ring-primary-500
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">
                        <option value="1" {{ old('stripe_mode', $settings['stripe_mode'] ?? 1) == 1 ? 'selected' : '' }}>Test</option>
                        <option value="0" {{ old('stripe_mode', $settings['stripe_mode'] ?? 1) == 0 ? 'selected' : '' }}>Live</option>
                    </select>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400">Test for development, Live for production</span>
            </div>
        </div>
    </div>
</div>
