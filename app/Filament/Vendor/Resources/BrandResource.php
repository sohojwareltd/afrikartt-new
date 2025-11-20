<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\BrandResource\Pages;
use App\Models\Brand;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-star';
    protected static ?string $navigationLabel = 'Brands';
    protected static ?string $navigationGroup = 'Inventory';
    protected static ?int $navigationSort = 2;

    // public static function getEloquentQuery(): Builder
    // {
    //     $user = Auth::user();
    //     if (!$user || !$user->shop) {
    //         return parent::getEloquentQuery()->whereRaw('1 = 0');
    //     }

    //     return parent::getEloquentQuery()
    //         ->where('shop_id', $user->shop->id);
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\Hidden::make('shop_id')
                //     ->default(function () {
                //         $user = Auth::user();
                //         return $user && $user->shop ? $user->shop->id : null;
                //     }),

                Section::make('Brand Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Brand Name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(Brand::class, 'slug', ignoreRecord: true)
                            ->helperText('URL-friendly version of the brand name'),

                        Forms\Components\Hidden::make('status')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Toggle to activate or deactivate this brand'),
                    ])
                    ->columns(2),

                Section::make('Brand Details')
                    ->schema([
                        FileUpload::make('logo')
                            ->label('Brand Logo')
                            ->disk('public')
                            ->directory('brands')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('800')
                            ->imageResizeTargetHeight('450')
                            ->helperText('Upload brand logo (recommended: 800x450px)'),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->maxLength(1000)
                            ->helperText('Brief description about the brand'),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->label('Logo')
                    ->square()
                    ->defaultImageUrl(url('/placeholder/brand-placeholder.png')),

                TextColumn::make('name')
                    ->label('Brand Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Slug copied to clipboard')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Products')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                // ToggleColumn::make('status')
                //     ->label('Active')
                //     ->sortable(),
                TextColumn::make('status')
                    ->label('Active')
                    ->formatStateUsing(fn($state) => $state ? 'Active' : 'Disabled')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('All brands')
                    ->trueLabel('Active brands')
                    ->falseLabel('Inactive brands'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }

    // public static function getNavigationBadge(): ?string
    // {
    //     $user = Auth::user();
    //     if (!$user || !$user->shop) {
    //         return null;
    //     }

    //     return static::getModel()::where('shop_id', $user->shop->id)
    //         ->where('status', true)
    //         ->count();
    // }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}