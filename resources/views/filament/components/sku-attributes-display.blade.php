@php
    // View component receives data as variables from the data() method
    $attributes = $attributes ?? [];
    $message = $message ?? null;
@endphp

<div>
    @if($message)
        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $message }}</p>
    @elseif(empty($attributes))
        <p class="text-xs text-gray-500 dark:text-gray-400">No attributes assigned</p>
    @else
        <div class="space-y-1.5">
            @foreach($attributes as $attr)
                <div class="flex items-center gap-2 text-sm">
                    <span class="font-medium text-gray-700 dark:text-gray-300">
                        {{ $attr['name'] ?? 'Unknown' }}:
                    </span>
                    @if(isset($attr['type']) && $attr['type'] === 'image' && !empty($attr['value']))
                        <img src="{{ asset('storage/' . $attr['value']) }}" 
                             class="w-8 h-8 rounded object-cover border border-gray-200 dark:border-gray-700" 
                             alt="{{ $attr['name'] ?? 'Attribute' }}"
                             loading="lazy">
                    @else
                        <span class="text-gray-600 dark:text-gray-400">{{ $attr['value'] ?? '' }}</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>
