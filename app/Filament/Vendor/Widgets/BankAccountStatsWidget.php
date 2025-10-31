<?php

namespace App\Filament\Vendor\Widgets;

use App\Models\BankAccount;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class BankAccountStatsWidget extends BaseWidget
{
    protected static ?string $pollingInterval = '30s';
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $userId = Auth::id();
        
        if (!$userId) {
            return [];
        }

        $totalAccounts = BankAccount::where('user_id', $userId)->count();
        $activeAccounts = BankAccount::where('user_id', $userId)->where('status', 'active')->count();
        $defaultAccount = BankAccount::where('user_id', $userId)->where('is_default', true)->first();

        return [
            Stat::make('Total Bank Accounts', $totalAccounts)
                ->description($totalAccounts === 0 ? 'No accounts added yet' : 'Accounts in your profile')
                ->descriptionIcon($totalAccounts === 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-building-library')
                ->color($totalAccounts === 0 ? 'warning' : 'success')
                ->url(route('filament.vendor.resources.bank-accounts.index')),

            Stat::make('Active Accounts', $activeAccounts)
                ->description($activeAccounts === 0 ? 'No active accounts' : 'Ready for payments')
                ->descriptionIcon($activeAccounts === 0 ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                ->color($activeAccounts === 0 ? 'danger' : 'success'),

            Stat::make('Default Account', $defaultAccount ? $defaultAccount->bank_name : 'Not Set')
                ->description($defaultAccount ? 'Primary payment account' : 'Set a default account')
                ->descriptionIcon($defaultAccount ? 'heroicon-m-star' : 'heroicon-m-exclamation-triangle')
                ->color($defaultAccount ? 'warning' : 'danger')
                ->url($defaultAccount ? route('filament.vendor.resources.bank-accounts.view', $defaultAccount) : route('filament.vendor.resources.bank-accounts.create')),
        ];
    }

    public static function canView(): bool
    {
        $user = Auth::user();
        return $user && $user->role && in_array($user->role->name, ['vendor', 'admin']);
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
