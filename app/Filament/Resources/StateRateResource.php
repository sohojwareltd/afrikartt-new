<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StateRateResource\Pages;
use App\Filament\Resources\StateRateResource\RelationManagers;
use App\Models\StateRate;
use Doctrine\DBAL\Query\From;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateRateResource extends Resource
{
    protected static ?string $model = StateRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'State Rates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Location Information')
                    ->description('Specify the country and state for this shipping rate')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('country_id')
                                    ->label('Country')
                                    ->relationship('country', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Select the country or create a new one')
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Country Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('e.g., United States'),
                                        Forms\Components\TextInput::make('code')
                                            ->label('Country Code (ISO)')
                                            ->required()
                                            ->maxLength(3)
                                            ->placeholder('e.g., USA')
                                            ->helperText('2 or 3 letter ISO country code'),
                                    ])
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('state')
                                    ->label('State/Province')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., California, Ontario')
                                    ->helperText('Enter the state, province, or region name')
                                    ->columnSpan(1),
                            ]),
                    ]),

                Forms\Components\Section::make('Rate & Tax Configuration')
                    ->description('Define shipping rate and tax percentage for this location')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('rate')
                                    ->label('Shipping Rate')
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(999999.99)
                                    ->placeholder('0.00')
                                    ->helperText('Base shipping rate in USD')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('tax')
                                    ->label('Tax Rate')
                                    ->required()
                                    ->numeric()
                                    ->suffix('%')
                                    ->step(0.01)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->placeholder('0.00')
                                    ->helperText('Tax percentage for this location')
                                    ->columnSpan(1),

                                Forms\Components\Toggle::make('status')
                                    ->label('Active')
                                    ->required()
                                    ->default(true)
                                    ->inline(false)
                                    ->helperText('Enable or disable this rate')
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')
                    ->label('Country')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-globe-alt')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('state')
                    ->label('State/Province')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-map-pin')
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('rate')
                    ->label('Shipping Rate')
                    ->money('USD')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('tax')
                    ->label('Tax Rate')
                    ->formatStateUsing(fn($state) => number_format($state, 2) . '%')
                    ->sortable()
                    ->badge()
                    ->color('warning'),

                Tables\Columns\IconColumn::make('status')
                    ->label('Active')
                    ->boolean()
                    ->sortable()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('country.name', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('country_id')
                    ->relationship('country', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Country')
                    ->multiple(),

                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only')
                    ->placeholder('All rates')
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn($records) => $records->each->update(['status' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['status' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListStateRates::route('/'),
            'create' => Pages\CreateStateRate::route('/create'),
            'view' => Pages\ViewStateRate::route('/{record}'),
            'edit' => Pages\EditStateRate::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}
