<?php
namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Filament\Resources\MenuResource\RelationManagers\MenuItemsRelationManager;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
     protected static ?string $navigationGroup = 'Settings';
    protected static ?string $label = 'Menu';
    protected static ?string $pluralLabel = 'Menus';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Menu Details')
                ->icon('heroicon-o-bars-3')
                ->description('Create or update a menu for your site.')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Menu Name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Main Menu'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Menu Name')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-bars-3')
                    ->tooltip(fn($record) => $record->name),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->date('F j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([]);
    }

    public static function getRelations(): array
    {
        return [
            MenuItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
} 