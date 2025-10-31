<x-filament-panels::page>
    <div class="bg-white shadow rounded-2xl p-6 mb-8 border border-gray-200">
        <h2 class="text-2xl font-bold text-gray-900 mb-5">Offer Banner Page One </h2>
        <form wire:submit.prevent="submit">
            {{ $this->form }}
            <div class="pt-4 flex justify-end">
                <x-filament::button type="submit" color="primary">
                    Save
                </x-filament::button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
