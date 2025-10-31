<?php

namespace App\View\Components\Banner;

use App\Models\Banner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeEndFourCardBanner extends Component
{
    /**
     * Create a new component instance.
     */
    public bool $bannerExists;
    public function __construct()
    {
        $positions = [
            'Home End Four Card One',
            'Home End Four Card Two',
            'Home End Four Card Three',
            'Home End Four Card Four',
        ];

        $existing = Banner::whereIn('position', $positions)->pluck('position')->toArray();

        $this->bannerExists = count($existing) === count($positions);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.banner.home-end-four-card-banner');
    }
}
