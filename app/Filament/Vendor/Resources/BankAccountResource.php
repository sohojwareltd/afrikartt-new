<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\BankAccountResource\Pages;
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
use Illuminate\Support\Facades\Auth;

class BankAccountResource extends Resource
{
    protected static ?string $model = BankAccount::class;
    protected static ?string $navigationLabel = 'Bank Accounts';
    protected static ?string $navigationGroup = 'Financial';
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $recordTitleAttribute = 'display_name';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        // Only show bank accounts for the current vendor user
        return parent::getEloquentQuery()
            ->where('user_id', Auth::id());
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        return $user && $user->role && in_array($user->role->name, ['vendor', 'admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bank Information')
                    ->description('Enter your bank account details for payments.')
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
                                    ->placeholder('Full name as appears on account')
                                    ->default(fn() => Auth::user()->name . ' ' . (Auth::user()->l_name ?? '')),
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

                Forms\Components\Section::make('Additional Banking Details')
                    ->description('Optional information for international transfers.')
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
                    ->description('Set this account as your default payment account.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_default')
                                    ->label('Set as Default Account')
                                    ->helperText('This will be your primary account for receiving payments')
                                    ->default(fn() => !BankAccount::where('user_id', Auth::id())->where('is_default', true)->exists()),

                                Select::make('status')
                                    ->label('Account Status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->required()
                                    ->default('active')
                                    ->helperText('Only active accounts can receive payments'),
                            ]),
                    ]),

                // Hidden field to set current user as the owner
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bank_name')
                    ->label('Bank Name')
                    ->sortable()
                    ->searchable()
                    ->weight('bold')
                    ->icon('heroicon-o-building-library'),

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
                    ->label('Added')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),

                Tables\Filters\SelectFilter::make('account_type')
                    ->label('Account Type')
                    ->options(BankAccount::getAccountTypes()),

                Tables\Filters\Filter::make('is_default')
                    ->label('Default Account Only')
                    ->query(fn (Builder $query): Builder => $query->where('is_default', true)),
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
                        ->modalDescription('This will make this account your default for receiving payments and remove default status from other accounts.')
                        ->action(function (BankAccount $record) {
                            // Remove default from other accounts for this user
                            BankAccount::where('user_id', Auth::id())
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
                        ->modalHeading('Deactivate Bank Account')
                        ->modalDescription('Are you sure you want to deactivate this account? You won\'t receive payments to this account.')
                        ->action(function (BankAccount $record) {
                            $record->update(['status' => 'inactive']);
                            
                            // If this was the default, set another active account as default
                            if ($record->is_default) {
                                $newDefault = BankAccount::where('user_id', Auth::id())
                                    ->where('id', '!=', $record->id)
                                    ->where('status', 'active')
                                    ->first();
                                    
                                if ($newDefault) {
                                    $newDefault->update(['is_default' => true]);
                                }
                            }
                        })
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
                        ->before(function (BankAccount $record) {
                            // If deleting the default account, set another as default
                            if ($record->is_default) {
                                $newDefault = BankAccount::where('user_id', Auth::id())
                                    ->where('id', '!=', $record->id)
                                    ->where('status', 'active')
                                    ->first();
                                    
                                if ($newDefault) {
                                    $newDefault->update(['is_default' => true]);
                                }
                            }
                        })
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
            ->emptyStateHeading('No Bank Accounts')
            ->emptyStateDescription('Add your first bank account to start receiving payments.')
            ->emptyStateIcon('heroicon-o-building-library')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Bank Account')
                    ->icon('heroicon-o-plus'),
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
            'index' => Pages\ListBankAccounts::route('/'),
            'create' => Pages\CreateBankAccount::route('/create'),
            'view' => Pages\ViewBankAccount::route('/{record}'),
            'edit' => Pages\EditBankAccount::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return null;
            }

            $count = static::$model::where('user_id', $user->id)
                ->where('status', 'active')
                ->count();
            
            return $count > 0 ? (string) $count : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->display_name;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Bank' => $record->bank_name,
            'Type' => $record->account_type,
            'Status' => ucfirst($record->status),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'bank_name',
            'account_holder',
            'account_number',
        ];
    }

    public static function canCreate(): bool
    {
        // Allow vendors to add multiple bank accounts
        return true;
    }

    public static function canEdit(Model $record): bool
    {
        // Only allow editing own bank accounts
        return $record->user_id === Auth::id();
    }

    public static function canDelete(Model $record): bool
    {
        // Only allow deleting own bank accounts
        return $record->user_id === Auth::id();
    }

    public static function canView(Model $record): bool
    {
        // Only allow viewing own bank accounts
        return $record->user_id === Auth::id();
    }
}
