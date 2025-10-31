<?php

namespace App\Filament\Employee\Resources\Employee\ProductResource\Pages;

use App\Filament\Employee\Resources\Employee\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
