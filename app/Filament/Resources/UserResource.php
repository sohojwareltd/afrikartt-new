<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Users';
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        // Define the form schema for the User resource
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->description('Basic details about the user.')
                    ->schema([
                        TextInput::make('name')
                            ->label('First Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('l_name')
                            ->label('Last Name')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn(Page $livewire) => $livewire instanceof CreateRecord)
                            ->maxLength(255)
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->autocomplete('new-password'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Roles & Permissions')
                    ->description('Assign roles to the user.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('role_id')
                                    ->label('Primary Role')
                                    ->relationship('role', 'name')
                                    ->required(),
                                Select::make('roles')
                                    ->label('Additional Roles')
                                    ->relationship('roles', 'name')
                                    ->multiple()
                                    ->preload()
                                    ->required(),
                            ]),

                        FileUpload::make('avatar')
                            ->image()
                            ->directory('avatars')
                    
                            ->nullable(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $table->searchable();
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar')
                    ->label('Avatar')
                    ->disk('public')
                    ->circular()
                    ->size(48)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('First Name')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('l_name')
                    ->label('Last Name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Phone')
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->toggleable(isToggledHiddenByDefault: false),
            ])

            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('User Name')
                    ->query(
                        fn(Builder $query, array $data) =>
                        $query->when($data['value'], fn($q, $value) => $q->where('name', 'like', "%{$value}%"))
                    )
                    ->form([
                        TextInput::make('value')
                            ->label('Name')
                            ->placeholder('Search by name'),
                    ]),
            ])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()->icon('heroicon-o-eye')->label('User View'),
                    Tables\Actions\EditAction::make()->icon('heroicon-o-pencil')->label('User Edit'),
                    Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash')->label('User Delete'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;
        
        return static::$model::count();
    }
}
