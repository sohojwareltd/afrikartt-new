<?php

namespace App\Filament\Vendor\Resources\OfferRequestResource\Pages;

use App\Filament\Vendor\Resources\OfferRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOfferRequest extends EditRecord
{
    protected static string $resource = OfferRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
