<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\OfferRequestResource\Pages;
use App\Models\Offer;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class OfferRequestResource extends Resource
{

    protected static ?string $model = Offer::class;
    public static ?string $title = "Offer Requests";
    public static ?string $label = "Offer Requests";

    protected static ?string $navigationGroup = 'Orders';

    public static function getEloquentQuery(): Builder
    {
        $shop = auth()->user()->shop;

        return parent::getEloquentQuery()
            ->where('shop_id', $shop->id)
            ->latest();
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }


    public static function canCreate(): bool
    {
        return false;
    }
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->toggleable(true),
                TextColumn::make('user.name')->label('User Name')->sortable()->searchable()->toggleable(true),
                TextColumn::make('product.name')->label('Product Name')->sortable()->searchable()->toggleable(true),
                TextColumn::make('shop.name')->label('Shop Name')->sortable()->searchable()->toggleable(true),
                TextColumn::make('price')->label('Price')->sortable()->toggleable(true),
                TextColumn::make('massage')->label('Message')->limit(50)->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Activate',
                        0 => 'Decline',
                        default => 'Pending',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'success',
                        0 => 'danger',
                        default => 'warning',
                    }),

                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])

            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($record) {
                            $record->status = 1;
                            $record->save();
                        })
                        ->visible(fn($record) => $record->status === null)
                        ->requiresConfirmation(),

                    Tables\Actions\Action::make('decline')
                        ->label('Decline')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($record) {
                            $record->status = 0;
                            $record->save();
                        })
                        ->visible(fn($record) => $record->status === null)
                        ->requiresConfirmation(),

                    Tables\Actions\Action::make('info')
                        ->label('Already Action Created')
                        ->icon('heroicon-o-check-circle')
                        ->color('gray')
                        ->visible(fn($record) => $record->status === 0 || $record->status === 1)
                        ->disabled()
                ])->iconButton(),
            ])


            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOfferRequests::route('/'),
            // 'create' => Pages\CreateOfferRequest::route('/create'),
            // 'edit' => Pages\EditOfferRequest::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }
}
