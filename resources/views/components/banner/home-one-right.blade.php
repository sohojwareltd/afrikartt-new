<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    @if ($banner->image)
        <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'"
            alt="Home One Right Banner" style="cursor: pointer;object-fit:cover" height="400px" width="100%">
    @endif
</div>
