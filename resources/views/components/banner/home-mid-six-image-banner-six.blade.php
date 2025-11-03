 @php
     $home_mid_six_image_banner_six = App\Models\Banner::where('position', 'Home mid six image banner six')->first();
 @endphp
 @if ($home_mid_six_image_banner_six->image)
     <div class="col-12 col-md-2 mb-3 mb-md-0">
         <div class="card h-100 border-0 shadow-sm">
             <img src="{{ Storage::url($home_mid_six_image_banner_six->image) }}" onclick="window.location.href='{{ $home_mid_six_image_banner_six->url }}'"
                 class="card-img-top" alt="Home mid six image banner six" style="cursor: pointer; height: 100%;">

         </div>
     </div>
 @endif
