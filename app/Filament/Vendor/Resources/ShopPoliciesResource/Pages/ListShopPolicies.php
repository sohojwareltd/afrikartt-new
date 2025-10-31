<?php

namespace App\Filament\Vendor\Resources\ShopPoliciesResource\Pages;

use App\Filament\Vendor\Resources\ShopPoliciesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Table;

class ListShopPolicies extends ListRecords
{
    protected static string $resource = ShopPoliciesResource::class;
    protected static ?string $title = "Shop Policy";

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTable(): Table
    {
        return parent::getTable()
            ->paginated(false); // disables pagination
    }

    public function getHeader(): ?\Illuminate\Contracts\View\View
    {
        return view('filament.vendor.pages.shop-policies-header');
    }
}

