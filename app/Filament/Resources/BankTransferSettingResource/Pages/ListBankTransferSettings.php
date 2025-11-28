<?php

namespace App\Filament\Resources\BankTransferSettingResource\Pages;

use App\Filament\Resources\BankTransferSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBankTransferSettings extends ListRecords
{
    protected static string $resource = BankTransferSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action - only one settings record
        ];
    }
}
