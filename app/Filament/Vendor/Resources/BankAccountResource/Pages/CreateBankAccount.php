<?php

namespace App\Filament\Vendor\Resources\BankAccountResource\Pages;

use App\Filament\Vendor\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

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
            ->title('Bank Account Added')
            ->body('Your bank account has been added successfully. You can now receive payments to this account.')
            ->duration(6000);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the current user as the owner
        $data['user_id'] = Auth::id();
        
        // If this is set as default, remove default from other accounts for this user
        if ($data['is_default'] ?? false) {
            BankAccount::where('user_id', Auth::id())
                ->update(['is_default' => false]);
        }

        // If user has no bank accounts yet, make this the default
        $hasExistingAccounts = BankAccount::where('user_id', Auth::id())->exists();
        
        if (!$hasExistingAccounts || !BankAccount::where('user_id', Auth::id())->where('is_default', true)->exists()) {
            $data['is_default'] = true;
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        // Send notification about new bank account
        Notification::make()
            ->title('Payment Setup')
            ->body('Your bank account is ready for receiving payments from your sales.')
            ->success()
            ->persistent()
            ->send();
    }

    public function getTitle(): string
    {
        return 'Add New Bank Account';
    }

    public function getHeading(): string
    {
        return 'Add Bank Account';
    }

    public function getSubheading(): ?string
    {
        return 'Add a new bank account to receive payments from your sales';
    }
}
