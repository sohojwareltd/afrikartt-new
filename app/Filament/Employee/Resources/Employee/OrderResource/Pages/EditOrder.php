<?php

namespace App\Filament\Employee\Resources\Employee\OrderResource\Pages;

use App\Filament\Employee\Resources\Employee\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
