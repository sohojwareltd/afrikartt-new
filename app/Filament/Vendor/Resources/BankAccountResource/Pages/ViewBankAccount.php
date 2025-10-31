<?php

namespace App\Filament\Vendor\Resources\BankAccountResource\Pages;

use App\Filament\Vendor\Resources\BankAccountResource;
use App\Models\BankAccount;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Grid;
use Illuminate\Support\Facades\Auth;

class ViewBankAccount extends ViewRecord
{
    protected static string $resource = BankAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit Account')
                ->icon('heroicon-o-pencil')
                ->color('warning'),
            
            Actions\Action::make('set_default')
                ->label('Set as Default')
                ->icon('heroicon-o-star')
                ->color('warning')
                ->visible(fn (BankAccount $record): bool => !$record->is_default && $record->status === 'active')
                ->requiresConfirmation()
                ->modalHeading('Set as Default Account')
                ->modalDescription('This will make this account your default for receiving payments.')
                ->action(function (BankAccount $record) {
                    // Remove default from other accounts
                    BankAccount::where('user_id', Auth::id())
                        ->where('id', '!=', $record->id)
                        ->update(['is_default' => false]);
                    
                    $record->update(['is_default' => true]);
                })
                ->successNotificationTitle('Default account updated'),
            
            Actions\DeleteAction::make()
                ->label('Delete Account')
                ->icon('heroicon-o-trash')
                ->color('danger')
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
                }),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Bank Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('bank_name')
                                    ->label('Bank Name')
                                    ->weight('bold')
                                    ->icon('heroicon-o-building-library'),
                                
                                TextEntry::make('account_holder')
                                    ->label('Account Holder')
                                    ->icon('heroicon-o-user'),
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
                    ])
                    ->icon('heroicon-o-building-library'),

                Section::make('Additional Details')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('swift_code')
                                    ->label('SWIFT Code')
                                    ->placeholder('Not provided')
                                    ->icon('heroicon-o-globe-alt'),
                                
                                TextEntry::make('iban')
                                    ->label('IBAN')
                                    ->placeholder('Not provided')
                                    ->icon('heroicon-o-identification'),
                            ]),
                        
                        TextEntry::make('bank_address')
                            ->label('Bank Address')
                            ->placeholder('Not provided')
                            ->columnSpanFull()
                            ->icon('heroicon-o-map-pin'),
                    ])
                    ->collapsible()
                    ->icon('heroicon-o-globe-alt'),

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
                                    ->label('Added On')
                                    ->dateTime('M j, Y \a\t g:i A'),
                            ]),
                    ])
                    ->icon('heroicon-o-cog-6-tooth'),
            ]);
    }

    public function getTitle(): string
    {
        return 'Bank Account Details';
    }

    public function getHeading(): string
    {
        return $this->record->display_name;
    }

    public function getSubheading(): ?string
    {
        return 'Bank account information and settings';
    }
}
