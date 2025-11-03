<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Banners';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Banner')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->directory('banners')
                            ->image()
                            ->imagePreviewHeight('120')
                            ->required(),
                        Forms\Components\Select::make('position')
                            ->label('Position')
                            ->options([
                                'Hero left' => 'Hero left',
                                'Home 1 left' => 'Home 1 left',
                                'Home 1 right' => 'Home 1 right',
                                'Home mid six image banner one' => 'Home mid six image banner one',
                                'Home mid six image banner two' => 'Home mid six image banner two',
                                'Home mid six image banner three' => 'Home mid six image banner three',
                                'Home mid six image banner four' => 'Home mid six image banner four',
                                'Home mid six image banner five' => 'Home mid six image banner five',
                                'Home mid six image banner six' => 'Home mid six image banner six',
                                'Home catalog mid full' => 'Home catalog mid full',
                                'Home catalog bottom left' => 'Home catalog bottom left',
                                'Home catalog bottom right' => 'Home catalog bottom right',
                                'Home Mid Four Card One' => 'Home Mid Four Card One',
                                'Home Mid Four Card Two' => 'Home Mid Four Card Two',
                                'Home Mid Four Card Three' => 'Home Mid Four Card Three',
                                'Home Mid Four Card Four' => 'Home Mid Four Card Four',
                                'Home End Four Card One' => 'Home End Four Card One',
                                'Home End Four Card Two' => 'Home End Four Card Two',
                                'Home End Four Card Three' => 'Home End Four Card Three',
                                'Home End Four Card Four' => 'Home End Four Card Four',
                            ])
                            ->native(false)
                            ->required()
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('url')
                            ->label('URL')
                            ->url()
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Image')
                    ->square(),
                TextColumn::make('position')
                    ->label('Position')
                    ->searchable()
                    ->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}