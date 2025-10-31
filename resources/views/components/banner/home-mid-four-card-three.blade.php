 @if ($banner->image)
     <div class="col-12 col-md-3">
         <div class="card h-100 border-0 shadow-sm">
             <img src="{{ Storage::url($banner->image) }}" onclick="window.location.href='{{ $banner->url }}'"
                 class="card-img-top" alt="Ad 1" style="cursor: pointer; aspect-ratio: 1/1;">

         </div>
     </div>
 @endif
