<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VerificationResource\Pages;
use App\Filament\Resources\VerificationResource\RelationManagers;
use App\Models\Verification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\{TextColumn, BooleanColumn, ImageColumn};
use Filament\Forms\Components\{TextInput, DatePicker, FileUpload, Toggle, Select};
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VerificationResource extends Resource
{
    protected static ?string $model = Verification::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $navigationGroup = 'Business';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User & Contact')
                    ->icon('heroicon-o-user')
                    ->description('User selection and contact details')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('user_id')
                                    ->label('User')
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Phone Number')
                                    ->required()
                                    ->placeholder('e.g. +8801XXXXXXXXX'),
                                TextInput::make('paypal_email')
                                    ->label('PayPal Email')
                                    ->email()
                                    ->required()
                                    ->placeholder('user@email.com'),
                                DatePicker::make('dob')
                                    ->label('Date of Birth')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Section::make('Identification')
                    ->icon('heroicon-o-identification')
                    ->description('Government and card identification')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('tax_no')
                                    ->label('Tax Number')
                                    ->required(),
                                TextInput::make('card_no')
                                    ->label('Card Number')
                                    ->required(),
                                FileUpload::make('govt_id_front')
                                    ->label('Government ID Front')
                                    ->directory('verifications')
                                    ->image()
                                    ->imagePreviewHeight('80')
                                    ->required(),
                                FileUpload::make('govt_id_back')
                                    ->label('Government ID Back')
                                    ->directory('verifications')
                                    ->image()
                                    ->imagePreviewHeight('80')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Section::make('Bank Details')
                    ->icon('heroicon-o-banknotes')
                    ->description('Bank account and routing information')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('bank_ac')
                                    ->label('Bank Account')
                                    ->required(),
                                TextInput::make('ac_holder_name')
                                    ->label('Account Holder Name')
                                    ->required(),
                                TextInput::make('address')
                                    ->label('Address')
                                    ->required(),
                                TextInput::make('rtn')
                                    ->label('Routing Number')
                                    ->required(),
                            ]),
                    ]),
                Forms\Components\Section::make('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->description('Verification settings')
                    ->schema([
                        Toggle::make('ismonthly_charge')
                            ->label('Monthly Charge Enabled')
                            ->default(false)
                            ->helperText('Enable if this user should be charged monthly.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->toggleable(),
                TextColumn::make('paypal_email')
                    ->label('PayPal Email')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-envelope')
                    ->toggleable(),
                // TextColumn::make('dob')
                //     ->label('Date of Birth')
                //     ->sortable()
                //     ->searchable()
                //     ->icon('heroicon-o-calendar-days')
                //     ->toggleable(),
                TextColumn::make('tax_no')
                    ->label('Tax Number')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                // TextColumn::make('card_no')
                //     ->label('Card Number')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(),
                ImageColumn::make('signature')
                    ->label('signature')
                    ->size(48)
                    ->toggleable(),
                ImageColumn::make('govt_id_front')
                    ->label('Govt. ID Front')
                    ->size(48)
                    ->toggleable(),
                ImageColumn::make('govt_id_back')
                    ->label('Govt. ID Back')
                    ->size(48)
                    ->toggleable(),
                // TextColumn::make('bank_ac')
                //     ->label('Bank Account')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(),
                // TextColumn::make('ac_holder_name')
                //     ->label('Account Holder Name')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(),
                // TextColumn::make('address')
                //     ->label('Address')
                //     ->sortable()
                //     ->searchable()
                //     ->limit(30)
                //     ->tooltip(fn($record) => $record->address)
                //     ->toggleable(),
                // TextColumn::make('rtn')
                //     ->label('Routing Number')
                //     ->sortable()
                //     ->searchable()
                //     ->toggleable(),
                // BooleanColumn::make('ismonthly_charge')
                //     ->label('Monthly Charge Enabled')
                //     ->icon('heroicon-o-currency-dollar')
                //     ->sortable()
                //     ->toggleable(),
            ])

            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label('User')
                    ->relationship('user', 'name')
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('ismonthly_charge')
                    ->label('Monthly Charge Enabled'),

                Tables\Filters\Filter::make('dob')
                    ->label('Date of Birth')
                    ->form([
                        Forms\Components\DatePicker::make('dob_from')->label('From'),
                        Forms\Components\DatePicker::make('dob_to')->label('To'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['dob_from'], fn($q, $date) => $q->whereDate('dob', '>=', $date))
                            ->when($data['dob_to'], fn($q, $date) => $q->whereDate('dob', '<=', $date));
                    }),
            ])
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->button()
                    ->label('Filter'),
            )
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->icon('heroicon-o-eye')
                        ->label('View Verification')
                        ->url(fn (Verification $record): string => static::getUrl('show', ['record' => $record]))
                        ->openUrlInNewTab(false),
                    Tables\Actions\EditAction::make()->icon('heroicon-o-pencil')->label('Edit Verification'),
                    Tables\Actions\DeleteAction::make()->icon('heroicon-o-trash')->label('Delete Verification'),
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
            'index' => Pages\ListVerifications::route('/'),
            'create' => Pages\CreateVerification::route('/create'),
            'edit' => Pages\EditVerification::route('/{record}/edit'),
            'show' => Pages\ShowVerification::route('/{record}'),
        ];
    }
    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;
        
        return (string) Verification::count();
    }
}
