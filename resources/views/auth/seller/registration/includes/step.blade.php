@php
    $isActive = $current_step > $index;
    $connectorBg = $isActive
        ? 'linear-gradient(90deg, var(--accent-color) 100%, var(--accent-color) 100%)'
        : 'linear-gradient(90deg, #e5e7eb 100%, #e5e7eb 100%)';
    $circleBg = $isActive ? 'var(--accent-color)' : 'rgb(229, 231, 235)';
    $circleColor = $isActive ? '#fff' : 'rgb(156, 163, 175)';
    $circleFontSize = $isActive ? '1.1rem' : '1.2rem';
    $circleShadow = $isActive
        ? '0 3px 12px rgba(var(--accent-color-rgb), 0.25)'
        : '0 3px 12px rgba(0, 0, 0, 0.1)';
    $titleColorStyle = $isActive ? 'color: var(--accent-color) !important;' : '';
    $subtitleColorStyle = $isActive ? 'color: var(--accent-color) !important;' : '';
@endphp

@if (!$loop->first)
<div class="d-flex flex-column align-items-center">
    <div style="height: 4px; width: 50px; background: {{ $connectorBg }}; border-radius: 2px;"></div>
</div>
@endif

<div class="d-flex flex-column align-items-center" @if(!$isActive) style="cursor: pointer;" @endif>
    <div
        style="width: 42px; height: 42px; background: {{ $circleBg }}; color: {{ $circleColor }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: {{ $circleFontSize }}; box-shadow: {{ $circleShadow }}; transition: all 0.3s ease;">
        @if ($isActive)
            <i class="fas fa-check"></i>
        @else
            {{ $index }}
        @endif
    </div>
    <span class="mt-2 small text-secondary fw-medium fw-bold" style="{{ $titleColorStyle }}">Step {{ $index }}</span>
    <span class="small text-muted" style="font-size: 0.75rem; {{ $subtitleColorStyle }}">{{ $step }}</span>
</div>