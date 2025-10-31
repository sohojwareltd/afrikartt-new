<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Widgets\Widget;

class OrderStatusSummary extends Widget
{
    protected static string $view = 'filament.resources.order-resource.pages.order-status-summary';

    protected function getViewData(): array
    {
        return [
            'pending' => Order::where('status', 0)->count(),
            'paid' => Order::where('status', 1)->count(),
            'on_its_way' => Order::where('status', 2)->count(),
            'cancelled' => Order::where('status', 3)->count(),
            'delivered' => Order::where('status', 4)->count(),
        ];
    }
} 