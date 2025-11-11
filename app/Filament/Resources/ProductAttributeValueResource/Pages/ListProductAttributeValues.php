<?php

namespace App\Filament\Resources\ProductAttributeValueResource\Pages;

use App\Filament\Resources\ProductAttributeValueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListProductAttributeValues extends ListRecords
{
    protected static string $resource = ProductAttributeValueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->icon('heroicon-o-plus')
                ->label('New Attribute Value'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->badge(fn() => $this->getModel()::count()),

            'text' => Tab::make('Text Values')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 'text'))
                ->badge(fn() => $this->getModel()::where('type', 'text')->count()),

            'image' => Tab::make('Image Values')
                ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 'image'))
                ->badge(fn() => $this->getModel()::where('type', 'image')->count()),
        ];
    }
}
