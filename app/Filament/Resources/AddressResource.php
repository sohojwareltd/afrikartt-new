<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AddressResource\Pages;
use App\Filament\Resources\AddressResource\RelationManagers;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;
        
        return (string) static::$model::count();
    }
    // Add a toggle column for "is_active" status
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
    protected static ?string $model = Address::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Address Information')
                    ->description('Enter the address details for the user')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('first_name')
                                    ->label('First Name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('last_name')
                                    ->label('Last Name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Select::make('user_id')
                                    ->searchable()
                                    ->placeholder('Search User')
                                    ->label('User')
                                    ->relationship('user', 'name')
                                    ->required(),
                                Forms\Components\TextInput::make('company')
                                    ->label('Company')
                                    ->maxLength(255),
                               
                                Forms\Components\TextInput::make('phone')
                                    ->label('Phone')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('city')
                                    ->label('City')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('state')
                                    ->label('State')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('post_code')
                                    ->label('Postal Code')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('country')
                                    ->label('Country')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Grid::make(1)
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('address_1')
                                    ->label('Address Line 1')
                                    ->required()
                                    ->rows(4),
                                Forms\Components\Textarea::make('address_2')
                                    ->label('Address Line 2')
                                    ->rows(4),

                            ]),
                    ])
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company')
                    ->label('Company')
                    ->sortable()
                    ->toggleable(),
                // Tables\Columns\TextColumn::make('address_1')
                //     ->label('Address Line 1')
                //     ->limit(30)
                //     ->tooltip(fn($record) => $record->address_1)
                //     ->toggleable(),
                // Tables\Columns\TextColumn::make('city')
                //     ->label('City')
                //     ->sortable()
                //     ->toggleable(),
                // Tables\Columns\TextColumn::make('state')
                //     ->label('State')
                //     ->sortable()
                //     ->toggleable(),
                // Tables\Columns\TextColumn::make('post_code')
                //     ->label('Postal Code')
                //     ->sortable()
                //     ->toggleable(),
                // Tables\Columns\TextColumn::make('country')
                //     ->label('Country')
                //     ->sortable()
                //     ->badge()
                //     ->color('success')
                //     ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('country')
                    ->label('Country')
                    ->query(fn(Builder $query, array $data) => $query->when($data['value'], fn($q) => $q->where('country', $data['value'])))
                    ->form([
                        Forms\Components\TextInput::make('value')
                            ->label('Country')
                            ->placeholder('Enter country'),
                    ]),
                Tables\Filters\Filter::make('city')
                    ->label('City')
                    ->query(fn(Builder $query, array $data) => $query->when($data['value'], fn($q) => $q->where('city', $data['value'])))
                    ->form([
                        Forms\Components\TextInput::make('value')
                            ->label('City')
                            ->placeholder('Enter city'),
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View')
                        ->icon('heroicon-o-eye'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil-square'),
                ]),
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
            'index' => Pages\ListAddresses::route('/'),
            'create' => Pages\CreateAddress::route('/create'),
            'edit' => Pages\EditAddress::route('/{record}/edit'),
        ];
    }
}
