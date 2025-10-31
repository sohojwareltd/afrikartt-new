<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\view;
use Filament\Resources\Pages\Page;

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
