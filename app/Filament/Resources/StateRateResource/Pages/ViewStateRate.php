<?php

namespace App\Filament\Resources\StateRateResource\Pages;

use App\Filament\Resources\StateRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStateRate extends ViewRecord
{
    protected static string $resource = StateRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
