<?php

namespace App\View\Components\Banner;

use App\Models\Banner;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class HomeMidFourCardBanner extends Component
{
    public bool $bannerExists;

    public function __construct()
    {
        $positions = [
            'Home Mid Four Card One',
            'Home Mid Four Card Two',
            'Home Mid Four Card Three',
            'Home Mid Four Card Four',
        ];

        $existing = Banner::whereIn('position', $positions)->pluck('position')->toArray();

        $this->bannerExists = count($existing) === count($positions);
    }

    public function render(): View|Closure|string
    {
        return view('components.banner.home-mid-four-card-banner');
    }
}
