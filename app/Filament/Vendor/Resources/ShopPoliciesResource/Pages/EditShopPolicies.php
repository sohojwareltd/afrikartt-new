<?php

namespace App\Filament\Vendor\Resources\ShopPoliciesResource\Pages;

use App\Filament\Vendor\Resources\ShopPoliciesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopPolicies extends EditRecord
{
    protected static string $resource = ShopPoliciesResource::class;

    
    protected function getHeaderActions(): array
    {
        // dd(request());
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
