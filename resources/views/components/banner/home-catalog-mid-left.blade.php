<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
  @if ($banner->image)
    <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'"
        alt="Hero left banner" style="cursor: pointer;object-fit:cover" height="400px" width="100%">
  @endif
</div>
