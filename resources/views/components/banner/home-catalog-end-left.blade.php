<div>
    <!-- I begin to speak only when I am certain what I will say is not better left unsaid. - Cato the Younger -->
    @if ($banner->image)
        <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'"
            alt="Home Catalog End Left Banner" style="cursor: pointer;object-fit:cover" height="400px" width="100%">
    @endif
</div>
