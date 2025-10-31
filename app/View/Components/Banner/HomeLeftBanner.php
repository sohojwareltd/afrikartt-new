<?php

namespace App\View\Components\Banner;

use App\Models\Banner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeLeftBanner extends Component
{
    /**
     * Create a new component instance.
     */
    public Banner $banner;
    public function __construct()
    {
        if(Banner::where('position', 'Hero left')->exists()){
            $this->banner = Banner::where('position', 'Hero left')->first();
        }else{
            $this->banner = new Banner();
        }

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner.home-left-banner');
    }
}
