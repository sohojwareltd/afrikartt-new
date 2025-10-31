<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\{TextInput, Textarea, FileUpload, Toggle, Select};
use Filament\Tables\Columns\{TextColumn, BooleanColumn, ImageColumn, BadgeColumn};

class TicketResource extends Resource
{

    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Business';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('parent_id', null)->latest(); // assuming vendor has `shop_id`
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Ticket Details')
                    ->icon('heroicon-o-ticket')
                    ->description('Basic information about the support ticket')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('parent_id')
                                    ->label('Parent Ticket')
                                    ->relationship('parent', 'subject')
                                    ->searchable()
                                    ->nullable(),
                                Select::make('shop_id')
                                    ->label('Shop')
                                    ->relationship('shop', 'name')
                                    ->required(),
                                Select::make('user_id')
                                    ->label('User')
                                    ->relationship('user', 'name')
                                    ->required(),
                                TextInput::make('subject')
                                    ->label('Subject')
                                    ->maxLength(255)
                                    ->placeholder('Enter ticket subject'),
                            ]),
                    ]),
                Forms\Components\Section::make('Message & Attachment')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->description('Ticket message and optional image')
                    ->schema([
                        Textarea::make('massage')
                            ->label('Message')
                            ->rows(4)
                            ->placeholder('Describe your issue or request'),
                        FileUpload::make('image')
                            ->label('Attachment')
                            ->image()
                            ->directory('tickets')
                            ->nullable(),
                    ]),
                Forms\Components\Section::make('Status & Action')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description('Ticket status and workflow action')
                    ->schema([
                        Toggle::make('status')
                            ->label('Resolved')
                            ->helperText('Mark as resolved when the issue is fixed.'),
                        Select::make('action')
                            ->label('Action')
                            ->options([
                                0 => 'No Action',
                                1 => 'In Progress',
                                2 => 'Escalated',
                                3 => 'Closed',
                            ])
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Ticket ID')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->toggleable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Image')
                    ->circular()
                    ->size(48)
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('User')
                    ->icon('heroicon-o-user')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('shop.name')
                    ->label('Shop')
                    ->icon('heroicon-o-building-storefront')
                    ->searchable()
                    ->toggleable(),
                // TextColumn::make('subject')
                //     ->label('Subject')
                //     ->limit(30)
                //     ->searchable()
                //     ->toggleable(),
                BooleanColumn::make('status')
                    ->label('Resolved')
                    ->icon('heroicon-o-check-circle')
                    ->toggleable(),
                BadgeColumn::make('action')
                    ->label('Action')
                    ->colors([
                        'gray' => fn($state) => is_null($state) || $state === 0,
                        'warning' => 1,
                        'danger' => 2,
                        'success' => 3,
                    ])
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'No Action',
                        1 => 'In Progress',
                        2 => 'Escalated',
                        3 => 'Closed',
                        default => 'Unknown',
                    })
                    ->icon(fn($state) => match ($state) {
                        0 => 'heroicon-o-minus-circle',
                        1 => 'heroicon-o-arrow-path',
                        2 => 'heroicon-o-exclamation-triangle',
                        3 => 'heroicon-o-check-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->toggleable(),
                ImageColumn::make('image')
                    ->disk('public')
                    ->label('Attachment')
                    ->circular()
                    ->size(48)
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('F j, Y')
                    ->icon('heroicon-o-calendar-days')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Resolved')
                    ->options([
                        1 => 'Yes',
                        0 => 'No',
                    ]),
                Tables\Filters\SelectFilter::make('action')
                    ->label('Action')
                    ->options([
                        0 => 'No Action',
                        1 => 'In Progress',
                        2 => 'Escalated',
                        3 => 'Closed',
                    ]),
                Tables\Filters\Filter::make('created_at')
                    ->label('Created Date')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')->label('From'),
                        Forms\Components\DatePicker::make('created_until')->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['created_from'], fn($query, $date) => $query->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($query, $date) => $query->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('Reply to Ticket')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis'),
                    Tables\Actions\EditAction::make()
                        ->label('Edit Ticket')
                        ->icon('heroicon-o-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete Ticket')
                        ->icon('heroicon-o-trash'),
                ])->iconButton(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
            'view' => Pages\ViewTicket::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;
        
        return static::$model::where('parent_id', null)->count();
    }
}
