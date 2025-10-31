<?php

namespace App\Filament\Vendor\Pages;

use Filament\Pages\Page;
use Filament\Navigation\NavigationItem;

class CustomSubscriptionPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.vendor.pages.custom-subscription-page';

    protected static ?string $title = 'Subscriptions Management';

    public ?string $status = null;
    public $intent = null;

    public function mount(): void
    {
        $this->status = $this->subscriptionStatus();
        $intent = auth()->user()->createSetupIntent();
        $this->intent = $intent->client_secret;
    }

    public static function getNavigationItems(): array
    {
        // return [
        //     NavigationItem::make('Subscriptions')
        //         ->url(fn() => route('filament.vendor.pages.custom-subscription-page'))
        //         ->icon('heroicon-o-photo')
        //         ->group('Marketing')
        //         ->sort(5),
        // ];

        return [];
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }

    protected function subscriptionStatus(): string
    {
        $getSubscription = auth()->user()->getSubscription();
        if ($getSubscription->stripe_status !== 'active' || $getSubscription->ends_at !== null) {
            $status = false;
        } else {
            $status = true;
        }
        return $status;
    }
}
