<?php

namespace App\Filament\Vendor\Widgets;

use Filament\Widgets\Widget;

class VendorWelcomProfileWidget extends Widget
{
    protected static string $view = 'filament.vendor.widgets.vendor-welcom-profile-widget';

    protected int|string|array $columnSpan = 'full';

    public ?string $heading = 'Vendor Profile';

    public static function canView(): bool
    {
        
        $user = auth()->user();

        if ($user->role_id !== 3) {
            return false;
        }

        return $user->shop &&  $user->shop->status == 0 && !empty($user->shop->name) && !empty($user->shop->slug) && !empty($user->shop->email);
    }
}
