<?php

namespace App\Filament\Vendor\Resources\OrderResource\Pages;

use App\Filament\Vendor\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function getView(): string
    {
        return 'filament.vendor.pages.view-order';
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\Action::make('download_invoice')
    //             ->label('Download Invoice')
    //             ->icon('heroicon-o-arrow-down-tray')
    //             ->url(fn() => route('vendor.orders.invoice', $this->record->id)),  // make sure to pass the id
    //     ];
    // }
}
