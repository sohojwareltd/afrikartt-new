<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\TicketResource\Pages;
use App\Filament\Vendor\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationLabel = 'Tickets';
    protected static ?string $pluralLabel = 'Tickets';
    protected static ?string $navigationGroup = 'Support';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function getEloquentQuery(): Builder
    {
        $shop = auth()->user()->shop;
        return parent::getEloquentQuery()
            ->where('shop_id', $shop->id)->where('parent_id', null)->latest(); 
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->toggleable(),
                ImageColumn::make('image')->disk('public')->label('Image')->circular()->toggleable(),
                TextColumn::make('user.name')->label('User')->searchable()->toggleable(),
                TextColumn::make('shop.name')->label('Shop')->searchable()->toggleable(),
                TextColumn::make('subject')->limit(30)->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('massage')->limit(30)->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Open',
                        0 => 'Closed',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'success',
                        0 => 'danger',
                    })
                    ->toggleable(),
                BadgeColumn::make('action')
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
                    ->toggleable(),
                TextColumn::make('created_at')->label('Created')->dateTime()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                    ->label('Massage Reply'),
                    Tables\Actions\Action::make('toggleStatus')
                        ->label(fn($record) => $record->status ? 'Closed' : 'Open')
                        ->icon(fn($record) => $record->status ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                        ->color(fn($record) => $record->status ? 'danger' : 'success')
                        ->action(function ($record) {
                            $record->status = $record->status ? 0 : 1;
                            $record->save();
                        })
                        ->requiresConfirmation()
                ])->iconButton()
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
}
