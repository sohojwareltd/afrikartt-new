<?php

namespace App\Filament\Vendor\Resources\OrderResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Order;

class VendorOrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Orders This Month';

    protected function getData(): array
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $shop = $user?->shop;
        if (!$shop || !$shop->id) {
            // No shop, return empty chart
            return [
                'datasets' => [
                    [
                        'label' => 'Orders',
                        'data' => [],
                        'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                        'borderColor' => 'rgba(59, 130, 246, 1)',
                    ],
                ],
                'labels' => [],
            ];
        }
        $shopId = $shop->id;
        $orders = Order::where('shop_id', $shopId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->get()
            ->groupBy(fn($order) => $order->created_at->format('Y-m-d'));

        $labels = [];
        $data = [];
        foreach (range(1, now()->daysInMonth) as $day) {
            $date = now()->startOfMonth()->addDays($day - 1)->format('Y-m-d');
            $labels[] = $date;
            $data[] = isset($orders[$date]) ? $orders[$date]->count() : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line'; // or 'bar'
    }
}
