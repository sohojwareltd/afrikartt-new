<?php

namespace App\Filament\Resources\BankAccountResource\Pages;

use App\Filament\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBankAccount extends EditRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Account')
                ->icon('heroicon-o-eye'),
            
            Actions\Action::make('set_default')
                ->label('Set as Default')
                ->icon('heroicon-o-star')
                ->color('warning')
                ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                ->requiresConfirmation()
                ->modalHeading('Set as Default Account')
                ->modalDescription('This will make this account the default for the user.')
                ->action(function (BankAccount $record) {
                    // Remove default from other accounts
                    BankAccount::where('user_id', $record->user_id)
                        ->where('id', '!=', $record->id)
                        ->update(['is_default' => false]);
                    
                    $record->update(['is_default' => true]);
                })
                ->successNotificationTitle('Default account updated'),
            
            Actions\DeleteAction::make()
                ->label('Delete Account')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Bank Account Updated')
            ->body('The bank account has been updated successfully.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // If this is being set as default, remove default from other accounts for this user
        if ($data['is_default'] ?? false) {
            BankAccount::where('user_id', $data['user_id'])
                ->where('id', '!=', $this->record->id)
                ->update(['is_default' => false]);
        }

        // If this was the default account and is being changed to not default,
        // check if there are other active accounts to potentially set as default
        if (!($data['is_default'] ?? false) && $this->record->is_default) {
            $otherActiveAccount = BankAccount::where('user_id', $data['user_id'])
                ->where('id', '!=', $this->record->id)
                ->where('status', 'active')
                ->first();

            if ($otherActiveAccount) {
                $otherActiveAccount->update(['is_default' => true]);
            }
        }

        return $data;
    }

    protected function afterSave(): void
    {
        // Ensure user always has at least one default active account
        $user_id = $this->record->user_id;
        $hasDefault = BankAccount::where('user_id', $user_id)
            ->where('is_default', true)
            ->where('status', 'active')
            ->exists();

        if (!$hasDefault) {
            $firstActiveAccount = BankAccount::where('user_id', $user_id)
                ->where('status', 'active')
                ->first();

            if ($firstActiveAccount) {
                $firstActiveAccount->update(['is_default' => true]);
            }
        }
    }
}
