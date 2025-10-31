<?php

namespace App\Filament\Vendor\Widgets;

use Filament\Widgets\Widget;

class VendorProfileWidget extends Widget
{
    protected static string $view = 'filament.vendor.widgets.vendor-profile-widget';

    protected int|string|array $columnSpan = 'full';

    public ?string $heading = 'Vendor Profile';

    public static function canView(): bool
    {
        $user = auth()->user();

        if ($user->role_id !== 3) {
            return false;
        }
        // dd($user->shop);
        return $user->shop == null;
    }
}
