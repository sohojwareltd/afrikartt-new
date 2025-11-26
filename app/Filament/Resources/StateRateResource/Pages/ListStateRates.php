<?php

namespace App\Filament\Resources\StateRateResource\Pages;

use App\Filament\Resources\StateRateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStateRates extends ListRecords
{
    protected static string $resource = StateRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
