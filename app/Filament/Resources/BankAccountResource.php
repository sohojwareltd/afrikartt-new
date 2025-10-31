<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankAccountResource\Pages;
use App\Models\BankAccount;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;
    protected static ?string $navigationLabel = 'Bank Accounts';
    protected static ?string $navigationGroup = 'Financial';
    // protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $recordTitleAttribute = 'display_name';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Account Owner')
                    ->description('Select the user who owns this bank account.')
                    ->schema([
                        Select::make('user_id')
                            ->label('Account Owner')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Bank Information')
                    ->description('Primary bank and account details.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('bank_name')
                                    ->label('Bank Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Chase Bank, Bank of America'),

                                TextInput::make('account_holder')
                                    ->label('Account Holder Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Full name as appears on account'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                TextInput::make('account_number')
                                    ->label('Account Number')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Account number')
                                    ->password()
                                    ->revealable(),

                                TextInput::make('routing_number')
                                    ->label('Routing Number')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('9-digit routing number'),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Select::make('account_type')
                                    ->label('Account Type')
                                    ->options(BankAccount::getAccountTypes())
                                    ->required()
                                    ->default('Checking'),

                                Select::make('currency')
                                    ->label('Currency')
                                    ->options(BankAccount::getCurrencyOptions())
                                    ->required()
                                    ->default('USD')
                                    ->searchable(),
                            ]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Additional Details')
                    ->description('Optional bank information for international transfers.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('swift_code')
                                    ->label('SWIFT Code')
                                    ->maxLength(255)
                                    ->placeholder('8 or 11 character SWIFT/BIC code'),

                                TextInput::make('iban')
                                    ->label('IBAN')
                                    ->maxLength(255)
                                    ->placeholder('International Bank Account Number'),
                            ]),

                        TextInput::make('bank_address')
                            ->label('Bank Address')
                            ->maxLength(255)
                            ->placeholder('Bank branch address')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(),

                Forms\Components\Section::make('Account Settings')
                    ->description('Account status and preferences.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_default')
                                    ->label('Default Account')
                                    ->helperText('This will be the primary account for transactions'),

                                Select::make('status')
                                    ->label('Account Status')
                                    ->options(BankAccount::getStatusOptions())
                                    ->required()
                                    ->default('active'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Account Owner')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary'),

                TextColumn::make('bank_name')
                    ->label('Bank Name')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),

                TextColumn::make('account_holder')
                    ->label('Account Holder')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('masked_account_number')
                    ->label('Account Number')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('account_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Checking' => 'success',
                        'Savings' => 'info',
                        default => 'gray',
                    }),

                TextColumn::make('currency')
                    ->label('Currency')
                    ->badge()
                    ->color('warning'),

                IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'closed' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(BankAccount::getStatusOptions())
                    ->multiple(),

                Tables\Filters\SelectFilter::make('account_type')
                    ->label('Account Type')
                    ->options(BankAccount::getAccountTypes())
                    ->multiple(),

                Tables\Filters\SelectFilter::make('currency')
                    ->label('Currency')
                    ->options(BankAccount::getCurrencyOptions())
                    ->multiple(),

                Tables\Filters\Filter::make('is_default')
                    ->label('Default Accounts Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_default', true)),

                Tables\Filters\Filter::make('user')
                    ->label('Account Owner')
                    ->form([
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['user_id'],
                            fn (Builder $query, $userId): Builder => $query->where('user_id', $userId),
                        );
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon('heroicon-o-eye')
                        ->label('View Details'),
                    
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-pencil')
                        ->label('Edit Account'),
                    
                    Action::make('set_default')
                        ->label('Set as Default')
                        ->icon('heroicon-o-star')
                        ->color('warning')
                        ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                        ->requiresConfirmation()
                        ->modalHeading('Set as Default Account')
                        ->modalDescription('This will make this account the default for the user and remove default status from other accounts.')
                        ->action(function (BankAccount $record) {
                            // Remove default from other accounts for this user
                            BankAccount::where('user_id', $record->user_id)
                                ->where('id', '!=', $record->id)
                                ->update(['is_default' => false]);
                            
                            // Set this account as default
                            $record->update(['is_default' => true]);
                        })
                        ->successNotificationTitle('Default account updated successfully'),
                    
                    Action::make('deactivate')
                        ->label('Deactivate')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->visible(fn (BankAccount $record): bool => $record->status === 'active')
                        ->requiresConfirmation()
                        ->action(fn (BankAccount $record) => $record->update(['status' => 'inactive']))
                        ->successNotificationTitle('Account deactivated successfully'),
                    
                    Action::make('activate')
                        ->label('Activate')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn (BankAccount $record): bool => $record->status === 'inactive')
                        ->action(fn (BankAccount $record) => $record->update(['status' => 'active']))
                        ->successNotificationTitle('Account activated successfully'),
                    
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->label('Delete Account')
                        ->requiresConfirmation()
                        ->modalHeading('Delete Bank Account')
                        ->modalDescription('Are you sure you want to delete this bank account? This action cannot be undone.')
                        ->successNotificationTitle('Bank account deleted successfully'),
                ])->icon('heroicon-o-ellipsis-vertical')
                  ->button()
                  ->label('Actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Delete Selected Bank Accounts')
                        ->modalDescription('Are you sure you want to delete the selected bank accounts? This action cannot be undone.'),
                    
                    Tables\Actions\BulkAction::make('bulk_deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status' => 'inactive'])))
                        ->successNotificationTitle('Selected accounts deactivated successfully'),
                    
                    Tables\Actions\BulkAction::make('bulk_activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(fn ($records) => $records->each(fn ($record) => $record->update(['status' => 'active'])))
                        ->successNotificationTitle('Selected accounts activated successfully'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->searchable();
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'view' => Pages\ViewBankAccount::route('/{record}'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::$model::where('status', 'active')->count();
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->display_name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Owner' => $record->user->name,
            'Type' => $record->account_type,
            'Status' => ucfirst($record->status),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'bank_name',
            'account_holder',
            'user.name',
            'account_number',
        ];
    }
}
