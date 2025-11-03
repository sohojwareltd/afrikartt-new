 @php
     $home_mid_six_image_banner_four = App\Models\Banner::where('position', 'Home mid six image banner four')->first();
 @endphp
 @if ($home_mid_six_image_banner_four->image)
     <div class="col-12 col-md-2 mb-3 mb-md-0">
         <div class="card h-100 border-0 shadow-sm">
             <img src="{{ Storage::url($home_mid_six_image_banner_four->image) }}" onclick="window.location.href='{{ $home_mid_six_image_banner_four->url }}'"
                 class="card-img-top" alt="Home mid six image banner four" style="cursor: pointer; height: 100%;">

         </div>
     </div>
 @endif
