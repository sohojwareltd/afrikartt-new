<?php

namespace App\Filament\Vendor\Resources\OfferChargeResource\Pages;

use App\Filament\Vendor\Resources\OfferChargeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferCharge extends EditRecord
{
    protected static string $resource = OfferChargeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
