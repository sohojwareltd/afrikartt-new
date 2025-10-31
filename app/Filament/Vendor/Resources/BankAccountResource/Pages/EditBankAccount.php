<?php

namespace App\Filament\Vendor\Resources\BankAccountResource\Pages;

use App\Filament\Vendor\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditBankAccount extends EditRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('View Account')
                ->icon('heroicon-o-eye')
                ->color('gray'),
            
            Actions\Action::make('set_default')
                ->label('Set as Default')
                ->icon('heroicon-o-star')
                ->color('warning')
                ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                ->requiresConfirmation()
                ->modalHeading('Set as Default Account')
                ->modalDescription('This will make this account your default for receiving payments.')
                ->action(function (BankAccount $record) {
                    // Remove default from other accounts
                    BankAccount::where('user_id', Auth::id())
                        ->where('id', '!=', $record->id)
                        ->update(['is_default' => false]);
                    
                    $record->update(['is_default' => true]);
                })
                ->successNotificationTitle('Default account updated'),
            
            Actions\DeleteAction::make()
                ->label('Delete Account')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Delete Bank Account')
                ->modalDescription('Are you sure you want to delete this bank account? This action cannot be undone.')
                ->before(function (BankAccount $record) {
                    // If deleting the default account, set another as default
                    if ($record->is_default) {
                        $newDefault = BankAccount::where('user_id', Auth::id())
                            ->where('id', '!=', $record->id)
                            ->where('status', 'active')
                            ->first();
                            
                        if ($newDefault) {
                            $newDefault->update(['is_default' => true]);
                        }
                    }
                }),
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
            ->body('Your bank account has been updated successfully.')
            ->duration(5000);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ensure the user_id remains the current user
        $data['user_id'] = Auth::id();
        
        // If this is being set as default, remove default from other accounts for this user
        if ($data['is_default'] ?? false) {
            BankAccount::where('user_id', Auth::id())
                ->where('id', '!=', $this->record->id)
                ->update(['is_default' => false]);
        }

        // If this was the default account and is being changed to not default,
        // check if there are other active accounts to potentially set as default
        if (!($data['is_default'] ?? false) && $this->record->is_default) {
            $otherActiveAccount = BankAccount::where('user_id', Auth::id())
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
        $userId = Auth::id();
        $hasDefault = BankAccount::where('user_id', $userId)
            ->where('is_default', true)
            ->where('status', 'active')
            ->exists();

        if (!$hasDefault) {
            $firstActiveAccount = BankAccount::where('user_id', $userId)
                ->where('status', 'active')
                ->first();

            if ($firstActiveAccount) {
                $firstActiveAccount->update(['is_default' => true]);
                
                Notification::make()
                    ->warning()
                    ->title('Default Account Updated')
                    ->body('Since you removed the default status, we\'ve automatically set your first active account as default.')
                    ->persistent()
                    ->send();
            }
        }
    }

    public function getTitle(): string
    {
        return 'Edit Bank Account';
    }

    public function getHeading(): string
    {
        return 'Edit Bank Account';
    }

    public function getSubheading(): ?string
    {
        return 'Update your bank account information';
    }
}
