<?php

namespace App\Filament\Resources\BankAccountResource\Pages;

use App\Filament\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateBankAccount extends CreateRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Bank Account Created')
            ->body('The bank account has been created successfully.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // If this is set as default, remove default from other accounts for this user
        if ($data['is_default'] ?? false) {
            BankAccount::where('user_id', $data['user_id'])
                ->update(['is_default' => false]);
        }

        // Ensure at least one default account per user
        $hasDefault = BankAccount::where('user_id', $data['user_id'])
            ->where('is_default', true)
            ->exists();

        if (!$hasDefault && ($data['status'] ?? 'active') === 'active') {
            $data['is_default'] = true;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // You can add any post-creation logic here
        // For example, sending notifications, logging, etc.
    }
}
