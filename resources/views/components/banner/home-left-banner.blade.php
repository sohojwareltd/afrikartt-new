<div class="home-left-banner w-100">
    @if ($banner->image)
        <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'"
            alt="Home Left Banner" style="object-fit: fill; width: 100%; height: 100%; cursor: pointer;">
    @endif
</div>
