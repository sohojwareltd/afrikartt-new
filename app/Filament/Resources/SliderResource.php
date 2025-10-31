<?php

// app/Filament/Resources/SliderResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Sliders';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 2;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Slider Image')
                    ->icon('heroicon-o-photo')
                    ->description('Upload a high-quality image for the homepage slider.')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Slider Image')
                            ->disk('public')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->directory('sliders')
                            ->required(),
                    ]),

                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->maxLength(255),
                TextInput::make('order')
                    ->label('Order')
                    ->numeric()
                    ->minValue(0)
                    ->helperText('Determines the display order of sliders. Lower numbers appear first.')
                    ->default(0),
                Select::make('model')
                    ->label('Associated Model')
                    ->options([
                        'Product' => 'Product',
                        'Shop' => 'Shop',
                    ])
                    ->nullable()
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('model_id', null)),

                Select::make('model_id')
                    ->label('Select Item')
                    ->searchable()
                    ->options(function (callable $get) {
                        $model = $get('model');

                        if ($model === 'Product') {
                            return \App\Models\Product::query()
                                ->pluck('name', 'id');
                        }

                        if ($model === 'Shop') {
                            return \App\Models\Shop::query()
                                ->pluck('name', 'id');
                        }

                        return [];
                    })
                    ->reactive()
                    ->disabled(fn(callable $get) => !$get('model')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Slider Image'),
                TextColumn::make('order')->label('Order')->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
