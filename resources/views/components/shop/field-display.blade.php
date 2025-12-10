@props(['label', 'value', 'type' => 'text', 'rows' => 3, 'colSpan' => '1'])

@if (!empty($value))
    <div class="col-span-{{ $colSpan }}">
        <label class="text-sm font-medium leading-6 text-gray-950 dark:text-white">{{ $label }}</label>
        <div
            class="mt-2 fi-input-wrp flex rounded-lg shadow-sm ring-1 bg-gray-50 dark:bg-transparent ring-gray-950/10 dark:ring-white/10">
            <div class="fi-input-wrp-input min-w-0 flex-1">
                @if ($type === 'textarea')
                    <textarea disabled rows="{{ $rows }}"
                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500">{{ $value ?? 'N/A' }}</textarea>
                @else
                    <input type="text" disabled
                        class="fi-input block w-full border-none py-1.5 px-3 text-sm bg-white/0 text-gray-500"
                        value="{{ $value ?? 'N/A' }}">
                @endif
            </div>
        </div>
    </div>
@endif
