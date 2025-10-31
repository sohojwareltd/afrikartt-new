<div>
    <!-- The best way to take care of the future is to take care of the present moment. - Thich Nhat Hanh -->
    @if ($banner->image)
        <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'" alt="Home One Left Banner" style="cursor: pointer;object-fit:cover" height="400px" width="100%">
    @endif
</div>