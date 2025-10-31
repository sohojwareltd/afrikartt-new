<x-filament-panels::page>
    <div class="space-y-6">
        <!-- User & Contact Section -->
        <x-filament::section>
            <div class="flex items-center gap-3 mb-4">
                <x-filament::icon
                    name="heroicon-o-user"
                    class="h-6 w-6 text-primary-500"
                />
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">User & Contact Information</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">User</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->user->name ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->phone ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">PayPal Email</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->paypal_email ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Date of Birth</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->dob ? \Carbon\Carbon::parse($this->record->dob)->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </x-filament::section>

        <!-- Identification Section -->
        <x-filament::section>
            <div class="flex items-center gap-3 mb-4">
                <x-filament::icon
                    name="heroicon-o-identification"
                    class="h-6 w-6 text-primary-500"
                />
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Identification Documents</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Tax Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->tax_no ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Card Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->card_no ?? 'N/A' }}</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Government ID Front</label>
                    @if($this->record->govt_id_front)
                        <div class="mt-2">
                            <img src="{{ Storage::url($this->record->govt_id_front) }}" 
                                 alt="Government ID Front" 
                                 class="w-full max-w-xs h-auto rounded-lg border">
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No image uploaded</p>
                    @endif
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Government ID Back</label>
                    @if($this->record->govt_id_back)
                        <div class="mt-2">
                            <img src="{{ Storage::url($this->record->govt_id_back) }}" 
                                 alt="Government ID Back" 
                                 class="w-full max-w-xs h-auto rounded-lg border">
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No image uploaded</p>
                    @endif
                </div>
            </div>
        </x-filament::section>

        <!-- Bank Details Section -->
        <x-filament::section>
            <div class="flex items-center gap-3 mb-4">
                <x-filament::icon
                    name="heroicon-o-banknotes"
                    class="h-6 w-6 text-primary-500"
                />
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Bank Account Information</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Bank Account</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->bank_ac ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Account Holder Name</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->ac_holder_name ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->address ?? 'N/A' }}</p>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Routing Number</label>
                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $this->record->rtn ?? 'N/A' }}</p>
                </div>
            </div>
        </x-filament::section>

        <!-- Settings Section -->
        <x-filament::section>
            <div class="flex items-center gap-3 mb-4">
                <x-filament::icon
                    name="heroicon-o-cog-6-tooth"
                    class="h-6 w-6 text-primary-500"
                />
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Verification Settings</h2>
            </div>
            
            <div>
                <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Monthly Charge Enabled</label>
                <div class="mt-2">
                    @if($this->record->ismonthly_charge)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <x-filament::icon name="heroicon-o-check" class="w-4 h-4 mr-1" />
                            Enabled
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            <x-filament::icon name="heroicon-o-x-mark" class="w-4 h-4 mr-1" />
                            Disabled
                        </span>
                    @endif
                </div>
            </div>
        </x-filament::section>

        <!-- Signature Section -->
        @if($this->record->signature)
        <x-filament::section>
            <div class="flex items-center gap-3 mb-4">
                <x-filament::icon
                    name="heroicon-o-pencil-square"
                    class="h-6 w-6 text-primary-500"
                />
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Digital Signature</h2>
            </div>
            
            <div>
                <img src="{{ Storage::url($this->record->signature) }}" 
                     alt="Digital Signature" 
                     class="w-full max-w-xs h-auto rounded-lg border">
            </div>
        </x-filament::section>
        @endif
    </div>
</x-filament-panels::page>
