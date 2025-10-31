<?php

namespace App\Filament\Vendor\Resources\OrderResource\Pages;

use App\Filament\Vendor\Resources\OrderResource;
use Filament\Resources\Pages\Page;
use Illuminate\Contracts\View\View;

class OrderDetails extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.vendor.resources.order-resource.pages.order-details';

    public $record;

    public function mount($record): void
    {
        $this->record = $this->getRecord();
    }

    protected function getRecord()
    {
        $model = static::getResource()::getModel();
        return $model::findOrFail(request()->route('record'));
    }

    public function getViewData(): array
    {
        return [
            'record' => $this->record,
        ];
    }
}