<?php

namespace App\Filament\Resources\PolarChartDashboardResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class DashboardChart extends ChartWidget
{
    protected static ?string $heading = 'Order Status Distribution';
    protected static ?string $icon = 'heroicon-o-chart-pie';
    protected static ?string $title = 'Polar Area Chart';
    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        // Status labels and corresponding colors
        $statusLabels = [
            0 => 'Pending',
            1 => 'Paid',
            2 => 'On Its Way',
            3 => 'Cancelled',
            4 => 'Delivered',
        ];

        $statusColors = [
            0 => 'rgb(255, 99, 132)',   // Red
            1 => 'rgb(75, 192, 192)',   // Green
            2 => 'rgb(255, 205, 86)',   // Yellow
            3 => 'rgb(201, 203, 207)',  // Grey
            4 => 'rgb(54, 162, 235)',   // Blue
        ];

        // Get counts grouped by status
        $orders = Order::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        $data = [];
        $colors = [];
        $labels = [];
        $total = array_sum($orders);

        foreach ($statusLabels as $status => $label) {
            $labels[] = $label;
            $data[] = $orders[$status] ?? 0;
            $colors[] = $statusColors[$status];
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Orders by Status',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            // Custom options for tooltips and legend
            'options' => [
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'bottom',
                    ],
                    'tooltip' => [
                        'callbacks' => [
                            'label' => \Illuminate\Support\Js::from("function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = " . ($total ?: 1) . ";
                                let percent = total ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percent + '%)';
                            }"),
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'polarArea';
    }
}
