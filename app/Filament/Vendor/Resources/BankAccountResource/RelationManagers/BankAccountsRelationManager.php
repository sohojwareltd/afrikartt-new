<?php

namespace App\Filament\Vendor\Resources\BankAccountResource\RelationManagers;

use App\Models\BankAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class BankAccountsRelationManager extends RelationManager
{
    protected static string $relationship = 'bankAccounts';
    protected static ?string $recordTitleAttribute = 'display_name';
    protected static ?string $title = 'Bank Accounts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Bank Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('account_holder')
                            ->label('Account Holder')
                            ->required()
                            ->maxLength(255)
                            ->default(fn() => Auth::user()->name . ' ' . (Auth::user()->l_name ?? '')),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('account_number')
                            ->label('Account Number')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->revealable(),

                        Forms\Components\TextInput::make('routing_number')
                            ->label('Routing Number')
                            ->required()
                            ->maxLength(255),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('account_type')
                            ->label('Account Type')
                            ->options(BankAccount::getAccountTypes())
                            ->required()
                            ->default('Checking'),

                        Forms\Components\Select::make('currency')
                            ->label('Currency')
                            ->options(BankAccount::getCurrencyOptions())
                            ->required()
                            ->default('USD'),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Toggle::make('is_default')
                            ->label('Default Account'),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                            ])
                            ->required()
                            ->default('active'),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('display_name')
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('masked_account_number')
                    ->label('Account Number')
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('account_type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Checking' => 'success',
                        'Savings' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\IconColumn::make('is_default')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-star')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->label('Default'),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'warning',
                        'closed' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('M j, Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
                Tables\Filters\Filter::make('is_default')
                    ->query(fn ($query) => $query->where('is_default', true))
                    ->label('Default Only'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Bank Account'),
            ])
            ->actions([
                Tables\Actions\Action::make('set_default')
                    ->label('Set Default')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                    ->action(function (BankAccount $record) {
                        // Remove default from other accounts
                        BankAccount::where('user_id', $record->user_id)
                            ->where('id', '!=', $record->id)
                            ->update(['is_default' => false]);
                        
                        $record->update(['is_default' => true]);
                    }),
                
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Bank Accounts')
            ->emptyStateDescription('Add a bank account to start receiving payments.')
            ->emptyStateIcon('heroicon-o-building-library');
    }

    public function isReadOnly(): bool
    {
        // Allow vendors to manage their own bank accounts
        return false;
    }
}
