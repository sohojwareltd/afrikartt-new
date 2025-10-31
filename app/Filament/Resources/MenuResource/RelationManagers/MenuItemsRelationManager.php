<?php
namespace App\Filament\Resources\MenuResource\RelationManagers;

use App\Models\MenuItem;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Table;

class MenuItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $recordTitleAttribute = 'label';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Menu Item Details')
                ->icon('heroicon-o-link')
                ->schema([
                    Forms\Components\TextInput::make('title')->label('Title')->required()->maxLength(255),
                    Forms\Components\TextInput::make('url')->label('URL')->required()->maxLength(255),
                    Forms\Components\TextInput::make('icon_class')->label('Icon Class')->maxLength(100)->placeholder('e.g. fa fa-home'),
                    Forms\Components\TextInput::make('color')->label('Color')->maxLength(50)->placeholder('e.g. #3BB77E'),
                    Forms\Components\Select::make('parent_id')
                        ->label('Parent')
                        ->options(fn ($record) => MenuItem::where('menu_id', $record->menu_id ?? null)->pluck('title', 'id'))
                        ->searchable()
                        ->nullable(),
                    Forms\Components\TextInput::make('order')->label('Order')->numeric()->default(0),
                    Forms\Components\TextInput::make('target')->label('Target')->maxLength(20)->placeholder('_blank'),
                    Forms\Components\TextInput::make('route')->label('Route')->maxLength(255),
                    Forms\Components\Textarea::make('parameters')->label('Parameters')->rows(2),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->label('Title')->sortable()->searchable()->icon('heroicon-o-link')->tooltip(fn($record) => $record->label),
            Tables\Columns\TextColumn::make('url')->label('URL')->sortable()->toggleable(),
            Tables\Columns\TextColumn::make('icon_class')->label('Icon')->toggleable(),
            Tables\Columns\TextColumn::make('color')->label('Color')->toggleable(),
            Tables\Columns\TextColumn::make('order')->label('Order')->sortable()->badge()->color('primary'),
            Tables\Columns\TextColumn::make('parent.label')->label('Parent'),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->headerActions([
            Tables\Actions\CreateAction::make(),
        ])
        ->defaultSort('order')
        ->filters([
            //
        ]);
    }
} 