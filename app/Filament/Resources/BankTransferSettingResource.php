<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BankTransferSettingResource\Pages;
use App\Models\BankTransferSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BankTransferSettingResource extends Resource
{
    protected static ?string $model = BankTransferSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Bank Transfer Settings';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Method Status')
                    ->description('Enable or disable Direct Bank Transfer as a payment option')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Forms\Components\Toggle::make('enabled')
                            ->label('Enable Bank Transfer Payment')
                            ->helperText('When enabled, customers will see this option at checkout')
                            ->default(true)
                            ->inline(false),
                    ]),

                Forms\Components\Section::make('Bank Account Information')
                    ->description('Enter your US bank account details that customers will transfer money to')
                    ->icon('heroicon-o-building-library')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('bank_name')
                                    ->label('Bank Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., Bank of America')
                                    ->helperText('Official name of your bank')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('account_holder')
                                    ->label('Account Holder Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., John Doe')
                                    ->helperText('Name on the bank account')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('account_number')
                                    ->label('Account Number')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., 123456789')
                                    ->helperText('Your bank account number')
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('routing_number')
                                    ->label('Routing Number')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('e.g., 026009593')
                                    ->helperText('9-digit ABA routing number')
                                    ->columnSpan(1),

                                Forms\Components\Select::make('account_type')
                                    ->label('Account Type')
                                    ->required()
                                    ->options([
                                        'Checking' => 'Checking',
                                        'Savings' => 'Savings',
                                        'Business Checking' => 'Business Checking',
                                        'Business Savings' => 'Business Savings',
                                    ])
                                    ->default('Checking')
                                    ->helperText('Type of bank account')
                                    ->columnSpan(2),
                            ]),
                    ]),

                Forms\Components\Section::make('Customer Instructions')
                    ->description('Instructions shown to customers at checkout')
                    ->icon('heroicon-o-information-circle')
                    ->schema([
                        Forms\Components\Textarea::make('instructions')
                            ->label('Payment Instructions')
                            ->rows(5)
                            ->maxLength(2000)
                            ->placeholder('Enter instructions for customers...')
                            ->helperText('These instructions will be displayed on the checkout page')
                            ->default('Send the payment to the bank details above. Once the transfer is completed, upload your payment receipt or screenshot. Your order will be verified within 12–24 hours. After verification, your order will be marked as Paid and processed immediately.')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Receipt Upload Settings')
                    ->description('Configure payment receipt upload requirements')
                    ->icon('heroicon-o-document-arrow-up')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('require_receipt')
                                    ->label('Require Receipt Upload')
                                    ->helperText('Customers must upload payment proof')
                                    ->default(true)
                                    ->inline(false)
                                    ->columnSpan(1),

                                Forms\Components\TextInput::make('max_file_size')
                                    ->label('Max File Size (KB)')
                                    ->numeric()
                                    ->required()
                                    ->minValue(512)
                                    ->maxValue(10240)
                                    ->default(5120)
                                    ->suffix('KB')
                                    ->helperText('Maximum upload size (5120 KB = 5 MB)')
                                    ->columnSpan(1),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank Name')
                    ->searchable()
                    ->icon('heroicon-o-building-library'),

                Tables\Columns\TextColumn::make('account_holder')
                    ->label('Account Holder')
                    ->searchable(),

                Tables\Columns\TextColumn::make('account_number')
                    ->label('Account Number')
                    ->formatStateUsing(fn($state) => '****' . substr($state, -4))
                    ->copyable()
                    ->copyMessage('Account number copied'),

                Tables\Columns\IconColumn::make('enabled')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBankTransferSettings::route('/'),
            'edit' => Pages\EditBankTransferSetting::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $settings = BankTransferSetting::settings();
        return $settings->enabled ? 'Active' : 'Disabled';
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $settings = BankTransferSetting::settings();
        return $settings->enabled ? 'success' : 'danger';
    }
}
