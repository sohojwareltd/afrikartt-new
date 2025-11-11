<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductAttributeValueResource\Pages;
use App\Models\ProductAttribureValue;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class ProductAttributeValueResource extends Resource
{
    protected static ?string $model = ProductAttribureValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Product Management';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Attribute Values';

    protected static ?string $modelLabel = 'Attribute Value';

    protected static ?string $pluralModelLabel = 'Attribute Values';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Attribute Value Information')
                    ->schema([
                        Forms\Components\Select::make('attribute_id')
                            ->label('Attribute')
                            ->relationship('attribute', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique()
                                    ->placeholder('Enter attribute name'),
                            ])
                            ->helperText('Select or create an attribute (e.g., Color, Size, Material)')
                            ->columnSpanFull(),

                        Forms\Components\Select::make('type')
                            ->label('Value Type')
                            ->options([
                                'text' => 'Text',
                                'image' => 'Image',
                            ])
                            ->required()
                            ->default('text')
                            ->live()
                            ->helperText('Choose whether this value is text-based or image-based')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('value')
                            ->label('Value')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter value (e.g., Red, XL, Cotton)')
                            ->helperText('The actual value for this attribute')
                            ->visible(fn(Forms\Get $get) => $get('type') === 'text')
                            ->columnSpanFull(),

                        Forms\Components\FileUpload::make('value')
                            ->label('Image Value')
                            ->image()
                            ->directory('attribute-values')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '1:1',
                                '16:9',
                                '4:3',
                            ])
                            ->maxSize(2048)
                            ->helperText('Upload an image for this attribute value (max 2MB)')
                            ->visible(fn(Forms\Get $get) => $get('type') === 'image')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('attribute.name')
                    ->label('Attribute')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'text' => 'success',
                        'image' => 'warning',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->type == 'image' && $state) {
                            return 'Image: ' . basename($state);
                        }
                        return $state;
                    }),

                Tables\Columns\ImageColumn::make('value')
                    ->label('Image Preview')
                    ->circular()
                    ->size(40)
                    ->visible(fn($record) => $record?->type == 'image'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('M d, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attribute_id')
                    ->label('Attribute')
                    ->relationship('attribute', 'name')
                    ->searchable()
                    ->preload()
                    ->multiple(),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'text' => 'Text',
                        'image' => 'Image',
                    ])
                    ->multiple(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Created From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Created Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->after(function ($record) {
                        // Delete image file if type is image
                        if ($record->type === 'image' && $record->value) {
                            Storage::disk('public')->delete($record->value);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->after(function ($records) {
                            // Delete image files for image type records
                            foreach ($records as $record) {
                                if ($record->type === 'image' && $record->value) {
                                    Storage::disk('public')->delete($record->value);
                                }
                            }
                        }),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListProductAttributeValues::route('/'),
            'create' => Pages\CreateProductAttributeValue::route('/create'),
            'edit' => Pages\EditProductAttributeValue::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::count();

        if ($count > 50) {
            return 'success';
        } elseif ($count > 20) {
            return 'warning';
        }

        return 'primary';
    }
}