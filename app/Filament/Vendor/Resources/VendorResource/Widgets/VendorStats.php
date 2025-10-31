<?php

namespace App\Filament\Vendor\Resources\VendorResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class VendorStats extends BaseWidget
{
    protected function getCards(): array
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $vendor = $user && (property_exists($user, 'shop') || method_exists($user, 'shop')) ? $user->shop : null;
        if (!$vendor || !isset($vendor->id)) {
            // No shop, return empty cards
            return [];
        }
        $currentMonth = now()->format('M Y');
        $prevMonth = now()->subMonth()->format('M Y');

        $orderChange = $this->getPercentageChange(
            $this->getOrderCount($vendor->id, now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()),
            $this->getOrderCount($vendor->id, now()->startOfMonth(), now())
        );

        $revenueChange = $this->getPercentageChange(
            $this->getRevenueSum($vendor->id, now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()),
            $this->getRevenueSum($vendor->id, now()->startOfMonth(), now())
        );

        return [
            Card::make('Total Orders', $this->getOrderCount($vendor->id))
                ->description($this->getChangeDescription($orderChange, $currentMonth, $prevMonth))
                ->descriptionIcon($this->getChangeIcon($orderChange))
                ->chart($this->getOrderChartData($vendor->id))
                ->color('primary')
                ->icon('heroicon-o-shopping-cart')
                ->extraAttributes([
                    'class' => 'shadow-lg text-white bg-gradient-to-br from-blue-500 to-blue-700 border-0'
                ]),

            Card::make('Total Revenue', '$' . number_format($this->getRevenueSum($vendor->id), 2))
                ->description($this->getChangeDescription($revenueChange, $currentMonth, $prevMonth))
                ->descriptionIcon($this->getChangeIcon($revenueChange))
                ->chart($this->getRevenueChartData($vendor->id))
                ->color('success')
                ->icon('heroicon-o-currency-dollar')
                ->extraAttributes([
                    'class' => 'shadow-lg text-white bg-gradient-to-br from-green-500 to-green-700 border-0'
                ]),

            Card::make(
                'Pending Orders',
                Order::where('shop_id', $vendor->id)->where('status', 0)->count()
            )
                ->description('Orders awaiting processing')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->icon('heroicon-o-clock')
                ->extraAttributes([
                    'class' => 'shadow-lg text-white bg-gradient-to-br from-yellow-400 to-yellow-600 border-0'
                ]),

            Card::make(
                'Delivered Orders',
                Order::where('shop_id', $vendor->id)->where('status', 4)->count()
            )
                ->description('Orders delivered to customers')
                ->descriptionIcon('heroicon-o-truck')
                ->color('info')
                ->icon('heroicon-o-truck')
                ->extraAttributes([
                    'class' => 'shadow-lg text-white bg-gradient-to-br from-blue-400 to-blue-600 border-0'
                ]),
        ];
    }

    protected function getOrderCount($vendorId, $startDate = null, $endDate = null)
    {
        $query = Order::where('shop_id', $vendorId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->count();
    }

    protected function getRevenueSum($vendorId, $startDate = null, $endDate = null)
    {
        $query = Order::where('shop_id', $vendorId);

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        return $query->sum('total');
    }

    protected function getPercentageChange($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return 0;
        }
        return (($newValue - $oldValue) / $oldValue) * 100;
    }

    protected function getChangeDescription($change, $currentPeriod, $previousPeriod)
    {
        $direction = $change >= 0 ? 'increase' : 'decrease';
        $percentage = number_format(abs($change), 2);

        return "{$percentage}% {$direction} from {$previousPeriod}";
    }

    protected function getChangeIcon($change)
    {
        return $change >= 0
            ? 'heroicon-o-arrow-trending-up'
            : 'heroicon-o-arrow-trending-down';
    }

    protected function getChangeColor($change)
    {
        return $change >= 0 ? 'success' : 'danger';
    }

    protected function getOrderChartData($vendorId)
    {
        return Order::where('shop_id', $vendorId)
            ->select(DB::raw('COUNT(*) as count'), DB::raw('DATE(created_at) as date'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();
    }

    protected function getRevenueChartData($vendorId)
    {
        return Order::where('shop_id', $vendorId)
            ->select(DB::raw('SUM(total) as total'), DB::raw('DATE(created_at) as date'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total')
            ->toArray();
    }
}
