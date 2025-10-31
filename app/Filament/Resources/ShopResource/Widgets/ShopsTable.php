<?php

namespace App\Filament\Resources\ShopResource\Widgets;

use App\Models\Shop;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;

class ShopsTable extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Shop::query()->latest()->limit(10);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->label('Shop Name')->sortable()->searchable(),
            TextColumn::make('user.name')->label('Owner')->sortable()->searchable(),
            TextColumn::make('email')->label('Email')->sortable()->searchable(),
            TextColumn::make('phone')->label('Phone')->sortable(),
            BadgeColumn::make('status')
                ->label('Status')
                ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                ->colors([
                    'success' => true,
                    'danger' => false,
                ]),
            TextColumn::make('created_at')->label('Created')->dateTime('F j, Y'),
        ];
    }
} 