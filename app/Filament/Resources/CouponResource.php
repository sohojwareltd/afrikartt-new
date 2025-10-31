<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $model = Coupon::class;
    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coupon Details')
                    ->icon('heroicon-o-ticket')
                    ->description('Create or update a discount coupon for your customers.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label('Coupon Code')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->placeholder('E.g. SUMMER25'),
                                TextInput::make('discount')
                                    ->label('Discount (%)')
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(100)
                                    ->required()
                                    ->placeholder('E.g. 10'),
                                TextInput::make('minimum_cart')
                                    ->label('Minimum Cart Value')
                                    ->numeric()
                                    ->minValue(0)
                                    ->required()
                                    ->placeholder('E.g. 500'),
                                TextInput::make('limit')
                                    ->label('Usage Limit')
                                    ->numeric()
                                    ->minValue(1)
                                    ->required()
                                    ->placeholder('E.g. 100'),
                                DatePicker::make('start_at')
                                    ->label('Start Date')
                                    ->required()
                                    ->placeholder('Select start date'),
                                DatePicker::make('expire_at')
                                    ->label('Expiry Date')
                                    ->required()
                                    ->placeholder('Select expiry date'),


                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Coupon Code')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('discount')
                    ->label('Discount (%)')
                    ->sortable()
                    ->color('success')
                    ->toggleable(),
                TextColumn::make('minimum_cart')
                    ->label('Min Cart Value')
                    ->sortable()
                    ->money('USD')
                    ->toggleable(),
                TextColumn::make('limit')
                    ->label('Usage Limit')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('expire_at')
                    ->label('Expiry Date')
                    ->date('F j, Y')
                    ->color(fn($record) => $record->expire_at < now() ? 'danger' : 'primary')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('start_at')
                    ->label('Start Date')
                    ->date('F j, Y')
                    ->color(fn($record) => $record->start_at > now() ? 'warning' : 'success')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date('F j, Y')
                    ->icon('heroicon-o-calendar-days')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('expired')
                    ->label('Expired Coupons')
                    ->query(fn(Builder $query): Builder => $query->where('expire_at', '<', now())),
                Tables\Filters\Filter::make('active')
                    ->label('Active Coupons')
                    ->query(fn(Builder $query): Builder => $query->where('expire_at', '>=', now())),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash'),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;

        return static::$model::count();
    }
}
