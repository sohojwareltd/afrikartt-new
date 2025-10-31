<?php

namespace App\Filament\Resources\BankAccountResource\Pages;

use App\Filament\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Grid;

class ViewBankAccount extends ViewRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Account')
                ->icon('heroicon-o-pencil'),
            
            Actions\Action::make('set_default')
                ->label('Set as Default')
                ->icon('heroicon-o-star')
                ->color('warning')
                ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                ->requiresConfirmation()
                ->modalHeading('Set as Default Account')
                ->modalDescription('This will make this account the default for the user.')
                ->action(function (BankAccount $record) {
                    // Remove default from other accounts
                    BankAccount::where('user_id', $record->user_id)
                        ->where('id', '!=', $record->id)
                        ->update(['is_default' => false]);
                    
                    $record->update(['is_default' => true]);
                })
                ->successNotificationTitle('Default account updated'),
            
            Actions\DeleteAction::make()
                ->label('Delete Account')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Account Owner')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Account Owner')
                            ->badge()
                            ->color('primary'),
                        TextEntry::make('user.email')
                            ->label('Owner Email')
                            ->icon('heroicon-o-envelope'),
                    ])
                    ->columns(2),

                Section::make('Bank Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('bank_name')
                                    ->label('Bank Name')
                                    ->weight('bold'),
                                TextEntry::make('account_holder')
                                    ->label('Account Holder'),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('masked_account_number')
                                    ->label('Account Number')
                                    ->badge()
                                    ->color('gray'),
                                TextEntry::make('routing_number')
                                    ->label('Routing Number'),
                            ]),
                        
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('account_type')
                                    ->label('Account Type')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'Checking' => 'success',
                                        'Savings' => 'info',
                                        default => 'gray',
                                    }),
                                TextEntry::make('currency')
                                    ->label('Currency')
                                    ->badge()
                                    ->color('warning'),
                            ]),
                    ]),

                Section::make('Additional Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('swift_code')
                                    ->label('SWIFT Code')
                                    ->placeholder('Not provided'),
                                TextEntry::make('iban')
                                    ->label('IBAN')
                                    ->placeholder('Not provided'),
                            ]),
                        
                        TextEntry::make('bank_address')
                            ->label('Bank Address')
                            ->placeholder('Not provided')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                Section::make('Account Status')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                IconEntry::make('is_default')
                                    ->label('Default Account')
                                    ->boolean()
                                    ->trueIcon('heroicon-o-star')
                                    ->falseIcon('heroicon-o-star')
                                    ->trueColor('warning')
                                    ->falseColor('gray'),
                                
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'active' => 'success',
                                        'inactive' => 'warning',
                                        'closed' => 'danger',
                                        default => 'gray',
                                    }),
                                
                                TextEntry::make('created_at')
                                    ->label('Created At')
                                    ->dateTime(),
                            ]),
                    ]),
            ]);
    }
}
