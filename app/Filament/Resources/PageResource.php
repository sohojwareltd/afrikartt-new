<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationGroup = 'Blog';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Page';
    protected static ?string $modelLabel = 'Page';
    protected static ?string $slug = 'Page';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Post Details')
                    ->tabs([
                        Tabs\Tab::make('Basic Information')
                            ->schema([
                                Section::make('Post Information')
                                    ->description('Add the basic details about the post.')
                                    ->schema([
                                        Hidden::make('author_id')
                                            ->default(fn() => auth()->id()),

                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(
                                                fn(string $context, $state, callable $set) =>
                                                $context === 'create' ? $set('slug', Str::slug($state)) : null
                                            ),

                                        TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(Page::class, 'slug', ignoreRecord: true)
                                            ->rules(['alpha_dash']),
                                    ])->columns(2),

                                Section::make('Post Content')
                                    ->description('Write the full content and upload an image.')
                                    ->schema([
                                        Textarea::make('excerpt')
                                            ->columnSpanFull(),

                                        Select::make('layout_type')
                                            ->label('Page Layout')
                                            ->options([
                                                'default' => 'Normal Content',
                                                'accordion' => 'Accordion Layout',
                                            ])
                                            ->default('default')
                                            ->required()
                                            ->reactive(), // 👈 this makes visibility switching work

                                        RichEditor::make('body')
                                            ->label('Page Body')
                                            ->visible(fn(Get $get) => $get('layout_type') === 'default')
                                            ->columnSpanFull(),

                                        Repeater::make('accordions')
                                            ->label('Accordion Items')
                                            ->visible(fn(Get $get) => $get('layout_type') === 'accordion')
                                            ->schema([
                                                TextInput::make('title')->required(),
                                                RichEditor::make('content')
                                                    ->required()
                                                    ->columnSpanFull(),
                                            ])
                                            ->columnSpanFull()
                                            ->addActionLabel('Add Accordion Item'),

                                        FileUpload::make('image')
                                            ->image()
                                            ->directory('image')
                                            ->maxSize(4048),

                                        Select::make('status')
                                            ->required()
                                            ->options([
                                                'ACTIVE' => 'Active',
                                                'INACTIVE' => 'Inactive',
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('SEO Settings')
                            ->schema([
                                Section::make('SEO Metadata')
                                    ->description('Provide SEO keywords and description for better search visibility.')
                                    ->schema([
                                        Textarea::make('meta_description')
                                            ->columnSpanFull(),
                                        Textarea::make('meta_keywords')
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('author_id')
                    ->label('Author ID')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->label('Title'),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->label('Slug'),

                Tables\Columns\TextColumn::make('excerpt')
                    ->label('Excerpt')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('body')
                    ->label('Body')
                    ->formatStateUsing(fn($state) => Str::words($state, 3))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('meta_description')
                    ->label('Meta Description')
                    ->formatStateUsing(fn($state) => Str::words($state, 7))
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('meta_keywords')
                    ->label('Meta Keywords')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'ACTIVE',
                        'danger' => 'INACTIVE',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Updated At')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])



            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'ACTIVE' => 'Active',
                        'INACTIVE' => 'Inactive',
                    ]),



                // // Featured Filter (If you have "featured" column)
                // SelectFilter::make('featured')
                //     ->label('Featured')
                //     ->options([
                //         1 => 'Featured Only',
                //         0 => 'Non-Featured',
                //     ]),

                // Date Range Filter (If you have "created_at" or "published_at")
                Filter::make('created_at')
                    ->form([
                        DatePicker::make('from')->label('From Date'),
                        DatePicker::make('until')->label('To Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn($query) => $query->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($query) => $query->whereDate('created_at', '<=', $data['until']));
                    }),
            ])

            ->actions([
                ActionGroup::make([

                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),

                    // Change Status (with dropdown form)
                    Tables\Actions\Action::make('change_status')
                        ->label('Change Status')
                        ->icon('heroicon-o-adjustments-horizontal')
                        ->color('warning')
                        ->form([
                            Forms\Components\Select::make('status')
                                ->label('Select Status')
                                ->required()
                                ->options([
                                    'ACTIVE' => 'Active',
                                    'INACTIVE' => 'Inactive',
                                ]),
                        ])

                        ->action(
                            fn($record, array $data) =>
                            $record->update(['status' => $data['status']])
                        ),



                ])->tooltip('Actions')

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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'view' => Pages\ViewPage::route('/{record}'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
