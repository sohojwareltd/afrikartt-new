<?php

namespace App\Filament\Resources\BankTransferSettingResource\Pages;

use App\Filament\Resources\BankTransferSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBankTransferSetting extends EditRecord
{
    protected static string $resource = BankTransferSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No delete action for settings
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Bank transfer settings updated successfully';
    }

    protected function afterSave(): void
    {
        Notification::make()
            ->success()
            ->title('Settings Saved')
            ->body('Bank transfer payment settings have been updated.')
            ->send();
    }
}
