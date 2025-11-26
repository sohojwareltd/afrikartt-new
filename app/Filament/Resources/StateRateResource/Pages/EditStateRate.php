<?php

namespace App\Filament\Resources\StateRateResource\Pages;

use App\Filament\Resources\StateRateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStateRate extends EditRecord
{
    protected static string $resource = StateRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
