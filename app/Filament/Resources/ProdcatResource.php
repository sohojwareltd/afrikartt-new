<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdcatResource\Pages;
use App\Filament\Resources\ProdcatResource\RelationManagers;
use App\Models\Prodcat;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProdcatResource extends Resource
{
    protected static ?string $model = Prodcat::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Product Categories';

    protected static ?string $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Category Details')
                    ->icon('heroicon-o-squares-2x2')
                    ->description('Create or update a product category for your shop.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Category Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if (blank($get('slug'))) {
                                                    $set('slug', Str::slug($state));
                                                }
                                            })

                                            ->placeholder('E.g. Electronics'),
                                        TextInput::make('slug')
                                            ->label('Slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->rules([
                                                fn($record) => Rule::unique('prodcats', 'slug')->ignore($record?->id),
                                            ])
                                            ->dehydrateStateUsing(fn($state) => Str::slug($state)) // auto-clean on save
                                            ->placeholder('Auto-generated from name'),

                                        Select::make('parent_id')
                                            ->label('Parent Category')
                                            ->relationship('parent', 'name')
                                            ->getOptionLabelFromRecordUsing(fn($record) => $record?->name ?? '')
                                            ->searchable()
                                            ->preload()
                                            ->nullable(),
                                    ]),
                                FileUpload::make('logo')
                                    ->label('Category Logo')
                                    ->image()
                                    ->directory('categories')
                                    ->visibility('public')
                                    ->columnSpanFull()
                                    ->imagePreviewHeight('80'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->size(50),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('parent.name')
                    ->label('Parent Category')
                    ->sortable()
                    ->toggleable()
                    ->placeholder('Root Category'),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date('F j, Y') // Example: June 25, 2025
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([

                SelectFilter::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdcats::route('/'),
            'create' => Pages\CreateProdcat::route('/create'),
            'edit' => Pages\EditProdcat::route('/{record}/edit'),
        ];
    }
    public static function getLabel(): string
    {
        return 'Product Category';
    }

    public static function getPluralLabel(): string
    {
        return 'Product Categories';
    }
    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;

        return static::$model::count();
    }
}
