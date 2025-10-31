<?php

namespace App\Filament\Resources\StatsOverViewResource\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Total Orders', Order::count())
                ->description('All orders placed')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->chart(Order::selectRaw('COUNT(*) as count')
                    ->groupByRaw('DATE(created_at)')
                    ->orderByRaw('DATE(created_at)')
                    ->pluck('count')
                    ->toArray())
                ->color('primary'),

            Card::make('Total Users', User::count())
                ->description('Users registered')
                ->descriptionIcon('heroicon-o-user-group')
                ->chart(User::selectRaw('COUNT(*) as count')
                    ->groupByRaw('DATE(created_at)')
                    ->orderByRaw('DATE(created_at)')
                    ->pluck('count')
                    ->toArray())
                ->color('info'),

            Card::make('Total Sales', '$' . number_format(Order::sum('total'), 2))
                ->description('Revenue generated')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->chart(Order::selectRaw('SUM(total) as sum')
                    ->groupByRaw('DATE(created_at)')
                    ->orderByRaw('DATE(created_at)')
                    ->pluck('sum')
                    ->toArray())
                ->color('success'),
        ];
    }
}
