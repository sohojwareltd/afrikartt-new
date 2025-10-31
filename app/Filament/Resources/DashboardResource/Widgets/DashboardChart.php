<?php

namespace App\Filament\Resources\DashboardResource\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class DashboardChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Orders';
    protected static ?string $pollingInterval = '10s';
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();

        // Create an array with 12 months initialized to 0
        $orderCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $orderCounts[] = $monthlyOrders[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $orderCounts,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Can also use 'line', 'pie', etc.
    }
}

