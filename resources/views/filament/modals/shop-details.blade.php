{{-- resources/views/filament/modals/shop-details.blade.php --}}
<div class="space-y-6 p-2">
    <div class="flex items-center gap-4">
        @if ($shop->logo)
            <img src="{{ Storage::url($shop->logo) }}" alt="Logo" class="h-16 w-16 rounded shadow border">
        @endif
        <div>
            <div class="text-xl font-bold">{{ $shop->name }}</div>
            <div>
                <span class="font-semibold">Status:</span>
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                    {{ $shop->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $shop->status ? 'Active' : 'Inactive' }}
                </span>
            </div>
        </div>
    </div>
    @if ($shop->banner)
        <img src="{{ Storage::url($shop->banner) }}" alt="Banner" class="rounded w-full max-w-md shadow border">
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <div class="font-semibold text-gray-700 mb-1">Owner</div>
            <div><span class="font-medium">Name:</span> {{ $shop->user->name ?? 'N/A' }}</div>
            <div><span class="font-medium">Email:</span> {{ $shop->email }}</div>
            <div><span class="font-medium">Phone:</span> {{ $shop->phone }}</div>
        </div>
        <div>
            <div class="font-semibold text-gray-700 mb-1">Company</div>
            <div><span class="font-medium">Company Name:</span> {{ $shop->company_name }}</div>
            <div><span class="font-medium">Registration No.:</span> {{ $shop->company_registration }}</div>
        </div>
        <div>
            <div class="font-semibold text-gray-700 mb-1">Location</div>
            <div><span class="font-medium">City:</span> {{ $shop->city }}</div>
            <div><span class="font-medium">State:</span> {{ $shop->state }}</div>
            <div><span class="font-medium">Post Code:</span> {{ $shop->post_code }}</div>
            <div><span class="font-medium">Country:</span> {{ $shop->country }}</div>
        </div>
    </div>

    <div class="flex gap-2 mt-4">
        <form method="POST" action="{{ route('filament.admin.resources.shops.toggle-status', $shop) }}">
            @csrf
            <button type="submit"
                class="filament-button filament-button--sm bg-green-600 text-white rounded px-4 py-2 disabled:opacity-50" style="background: #056f83; color: #ffffff;"
                @if ($shop->status == 1) disabled @endif>
                Active
            </button>
        </form>
        <form method="POST" action="{{ route('filament.admin.resources.shops.toggle-status', $shop) }}">
            @csrf
            <input type="hidden" name="deactivate" value="1">
            <button type="submit"
                class="filament-button filament-button--sm bg-red-600 text-white rounded px-4 py-2 disabled:opacity-50" style="background: #ff0000; color: #ffffff;"
                @if ($shop->status == 0) disabled @endif>
                Deactivate
            </button>
        </form>
    </div>
</div>
