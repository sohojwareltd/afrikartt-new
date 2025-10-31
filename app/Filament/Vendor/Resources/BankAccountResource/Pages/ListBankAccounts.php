<?php

namespace App\Filament\Vendor\Resources\BankAccountResource\Pages;

use App\Filament\Vendor\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListBankAccounts extends ListRecords
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New Bank Account')
                ->icon('heroicon-o-plus')
                ->color('success'),
        ];
    }

    public function getTabs(): array
    {
        $userId = Auth::id();
        
        return [
            'all' => Tab::make('All Accounts')
                ->badge(BankAccount::where('user_id', $userId)->count()),
            
            'active' => Tab::make('Active')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'active'))
                ->badge(BankAccount::where('user_id', $userId)->where('status', 'active')->count()),
            
            'inactive' => Tab::make('Inactive')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'inactive'))
                ->badge(BankAccount::where('user_id', $userId)->where('status', 'inactive')->count()),
            
            'default' => Tab::make('Default Account')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('is_default', true))
                ->badge(BankAccount::where('user_id', $userId)->where('is_default', true)->count()),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // You can add custom widgets here if needed
        ];
    }

    public function getTitle(): string
    {
        return 'My Bank Accounts';
    }

    public function getHeading(): string
    {
        return 'Bank Accounts';
    }

    public function getSubheading(): ?string
    {
        return 'Manage your bank accounts for receiving payments from sales';
    }
}
