<?php

namespace App\Filament\Widgets;

use App\Models\Shop;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\HtmlString;

class ListLatestShops extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';
    protected static ?string $heading = 'Latest Shops';
    protected static ?int $sort = 3;

    protected function getTableQuery(): Builder
    {
        // return Shop::query()->latest()->limit(10);
        return Shop::query()
            ->where('status', 0)
            ->latest();
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('active')
                ->label('Active Shops')
                ->query(fn(Builder $query): Builder => $query->where('status', true)),
            Tables\Filters\Filter::make('inactive')
                ->label('Inactive Shops')
                ->query(fn(Builder $query): Builder => $query->where('status', false)),
            Tables\Filters\Filter::make('created_at')
                ->label('Created Date')
                ->form([
                    DatePicker::make('created_from')->label('From'),
                    DatePicker::make('created_until')->label('Until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when($data['created_from'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date))
                        ->when($data['created_until'], fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date));
                }),
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Store Name')
                ->sortable()
                ->searchable()
                ->icon('heroicon-o-shopping-bag')
                ->badge()
                ->color('primary'),
            TextColumn::make('user.name')
                ->label('Owner')
                ->icon('heroicon-o-user')
                ->toggleable(),

            TextColumn::make('email')
                ->label('Email')
                ->icon('heroicon-o-envelope')
                ->toggleable(),
            TextColumn::make('phone')
                ->label('Phone')
                ->icon('heroicon-o-phone')
                ->toggleable(),

            BooleanColumn::make('status')
                ->label('Active')
                ->icon('heroicon-o-check-circle')
                ->toggleable(),
            TextColumn::make('created_at')
                ->label('Created At')
                ->date('F j, Y')
                ->icon('heroicon-o-calendar-days')
                ->toggleable(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\ActionGroup::make([
                Tables\Actions\ViewAction::make()
                ->url(fn($record) => route('filament.admin.resources.shops.view', ['record' => $record]))
                ->openUrlInNewTab(),
            

                Tables\Actions\DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash'),
                Tables\Actions\Action::make('toggleStatus')
                    ->label(fn($record) => $record->status ? 'Deactivate' : 'Activate')
                    ->icon(fn($record) => $record->status ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn($record) => $record->status ? 'danger' : 'success')
                    ->action(function ($record) {
                        $record->status = $record->status ? 0 : 1;
                        $record->save();
                    })
                    ->requiresConfirmation(),
            ])->iconButton(),
        ];
    }
}
