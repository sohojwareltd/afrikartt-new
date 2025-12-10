<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Mail\BankTransferPaymentVerifiedMail;
use App\Mail\BankTransferPaymentRejectedMail;
use App\Mail\OrderStatusUpdatedMail;
use App\Models\Order;
use Filament\Forms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationGroup = 'Orders';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Orders List';

    protected static ?string $recordTitleAttribute = 'id';

    public static function getNavigationBadge(): ?string
    {
        $pendingBankPayments = static::$model::where('payment_method', 'bank_transfer')
            ->where('bank_payment_status', 'pending')
            ->count();

        return $pendingBankPayments > 0 ? (string) $pendingBankPayments : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $count = static::getNavigationBadge();
        return $count ? "{$count} bank transfer payment(s) pending verification" : null;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\Section::make('Order Details')
                            ->description('Basic information about the order')
                            ->icon('heroicon-o-shopping-cart')
                            ->schema([
                                Select::make('user_id')->relationship('user', 'name')->searchable()->nullable()->label('Customer'),
                                Select::make('shop_id')->relationship('shop', 'name')->searchable()->nullable()->label('Shop'),
                                Select::make('product_id')->relationship('product', 'name')->searchable()->nullable()->label('Product'),
                                Select::make('status')
                                    ->options([
                                        0 => 'Pending',
                                        1 => 'Paid',
                                        2 => 'On Its Way',
                                        3 => 'Cancelled',
                                        4 => 'Delivered',
                                    ])
                                    ->default(0)
                                    ->required()
                                    ->label('Order Status'),
                                TextInput::make('quantity')->required()->numeric()->label('Quantity'),

                                TextInput::make('customer_note')->nullable()->label('Customer Note'),
                                Toggle::make('order_accept')->label('Accepted')->default(false),
                                Toggle::make('seen')->default(false)->label('Seen'),
                            ])->columns(3),

                        Forms\Components\Section::make('Financials')
                            ->description('Order pricing and payment details')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextInput::make('currency')->maxLength(5)->nullable()->label('Currency'),
                                TextInput::make('subtotal')->required()->numeric()->label('Subtotal'),
                                TextInput::make('discount')->numeric()->nullable()->label('Discount'),
                                TextInput::make('discount_code')->nullable()->label('Discount Code'),
                                TextInput::make('shipping_total')->numeric()->nullable()->label('Shipping Total'),
                                TextInput::make('shipping_method')->nullable()->label('Shipping Method'),
                                TextInput::make('shipping_url')->nullable()->label('Shipping URL'),
                                TextInput::make('total')->required()->numeric()->label('Total'),
                                TextInput::make('vendor_total')->required()->numeric()->label('Vendor Total'),
                                TextInput::make('tax')->nullable()->numeric()->label('Tax'),
                            ])->columns(3),

                        Forms\Components\Section::make('Payment & Fulfillment')
                            ->description('Payment and fulfillment information')
                            ->icon('heroicon-o-credit-card')
                            ->schema([
                                TextInput::make('payment_method')->nullable()->label('Payment Method'),
                                TextInput::make('payment_method_title')->nullable()->label('Payment Method Title'),
                                TextInput::make('transaction_id')->nullable()->label('Transaction ID'),
                                DatePicker::make('date_paid')->nullable()->label('Date Paid'),
                                DatePicker::make('date_completed')->nullable()->label('Date Completed'),
                                TextInput::make('refund_amount')->nullable()->label('Refund Amount'),
                                TextInput::make('company')->nullable()->label('Company'),
                                TextInput::make('aptment')->nullable()->label('Apartment'),
                            ])->columns(2),

                        Forms\Components\Section::make('Returns')
                            ->description('Return reason and file upload')
                            ->icon('heroicon-o-arrow-uturn-left')
                            ->schema([
                                Textarea::make('return_reason')->nullable()->label('Return Reason'),
                                FileUpload::make('return_file')->directory('returns')->nullable()->label('Return File'),
                            ])->columns(1),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Order #')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('primary')
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Customer')
                    ->getStateUsing(
                        fn($record) =>
                        $record->user?->name
                            ? $record->user->name
                            : 'Guest Checkout'
                    )
                    ->icon(fn($record) => $record->user ? 'heroicon-o-user' : 'heroicon-o-user-circle')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                // TextColumn::make('shop.name')
                //     ->label('Shop')
                //     ->sortable()
                //     ->searchable()
                //     ->icon('heroicon-o-building-storefront')
                //     ->toggleable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->getStateUsing(fn($record) => $record->status) // FORCE state fix
                    ->formatStateUsing(fn($state) => match ((int)$state) {
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'On Its Way',
                        3 => 'Cancelled',
                        4 => 'Delivered',
                        default => 'Unknown',
                    })
                    ->color(fn($state) => match ((int)$state) {
                        0 => 'secondary',
                        1 => 'success',
                        2 => 'warning',
                        3 => 'danger',
                        4 => 'primary',
                        default => 'gray',
                    })
                    ->icon(fn($state) => match ((int)$state) {
                        0 => 'heroicon-o-clock',
                        1 => 'heroicon-o-currency-dollar',
                        2 => 'heroicon-o-truck',
                        3 => 'heroicon-o-x-circle',
                        4 => 'heroicon-o-check-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->toggleable(),
                BadgeColumn::make('payment_status')
                    ->label('Payment Status')
                    ->formatStateUsing(fn($state) => match ((int) $state) {
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'Failed',
                        3 => 'Cancelled',
                        default => 'Unknown',
                    })
                    ->color(fn($state) => match ((int) $state) {
                        0 => 'warning',
                        1 => 'success',
                        2 => 'danger',
                        3 => 'gray',
                        default => 'secondary',
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'stripe' => 'Card Payment',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Bank Transfer',
                        null => 'N/A',
                        default => ucfirst(str_replace('_', ' ', $state)),
                    })
                    ->badge()
                    ->icon(fn($state) => match ($state) {
                        'stripe' => 'heroicon-o-credit-card',
                        'paypal' => 'heroicon-o-banknotes',
                        'bank_transfer' => 'heroicon-o-building-library',
                        null => 'heroicon-o-question-mark-circle',
                        default => 'heroicon-o-currency-dollar',
                    })
                    ->color(fn($state) => match ($state) {
                        'stripe' => 'info',
                        'paypal' => 'warning',
                        'bank_transfer' => 'primary',
                        null => 'gray',
                        default => 'gray',
                    })
                    ->toggleable(),
                BadgeColumn::make('bank_payment_status')
                    ->label('Bank Payment')
                    ->visible(fn($record) => $record && $record->payment_method === 'bank_transfer')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'pending' => 'Pending Verification',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                        default => 'N/A',
                    })
                    ->color(fn($state) => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'verified' => 'heroicon-o-check-badge',
                        'rejected' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->toggleable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('USD')
                    ->sortable()
                    ->color('success')
                    ->toggleable(),
                // BooleanColumn::make('seen')
                //     ->label('Seen')
                //     ->icon('heroicon-o-eye')
                //     ->toggleable(),
                // BooleanColumn::make('order_accept')
                //     ->label('Accepted')
                //     ->icon('heroicon-o-check')
                //     ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('F j, Y')
                    ->icon('heroicon-o-calendar-days')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Order Status')
                    ->options([
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'On Its Way',
                        3 => 'Cancelled',
                        4 => 'Delivered',
                    ]),
                Tables\Filters\Filter::make('seen')
                    ->label('Seen')
                    ->query(fn(Builder $query) => $query->where('seen', true)),
                Tables\Filters\Filter::make('order_accept')
                    ->label('Accepted')
                    ->query(fn(Builder $query) => $query->where('order_accept', true)),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'stripe' => 'Card Payment (Stripe)',
                        'paypal' => 'PayPal',
                        'bank_transfer' => 'Bank Transfer',
                    ]),
                Tables\Filters\SelectFilter::make('bank_payment_status')
                    ->label('Bank Payment Status')
                    ->options([
                        'pending' => 'Pending Verification',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ])
                    ->query(
                        fn(Builder $query, $state) =>
                        $query->when(
                            $state['value'],
                            fn($query) =>
                            $query->where('payment_method', 'bank_transfer')
                                ->where('bank_payment_status', $state['value'])
                        )
                    ),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    // Tables\Actions\Action::make('orderDetails')
                    //     ->label('Order Details')
                    //     ->icon('heroicon-o-document-text')
                    //     ->url(fn($record) => route('filament.vendor.resources.orders.order-details', ['record' => $record])),
                    Tables\Actions\EditAction::make()
                        ->label('Edit')
                        ->icon('heroicon-o-pencil-square'),
                    Tables\Actions\DeleteAction::make()
                        ->label('Delete')
                        ->icon('heroicon-o-trash'),

                    // Order Status Update Action
                    Tables\Actions\Action::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->form([
                            Select::make('status')
                                ->label('Order Status')
                                ->options([
                                    0 => 'Pending',
                                    1 => 'Paid',
                                    2 => 'On Its Way',
                                    3 => 'Cancelled',
                                    4 => 'Delivered',
                                ])
                                ->required()
                                ->default(fn(Order $record) => $record->status),
                            Textarea::make('status_note')
                                ->label('Note (Optional)')
                                ->placeholder('Add any notes about this status change...')
                                ->rows(3),
                        ])
                        ->action(function (Order $record, array $data) {
                            $oldStatus = $record->status;
                            $newStatus = $data['status'];

                            // Update order status
                            $record->update([
                                'status' => $newStatus,
                            ]);

                            $statusNames = [
                                0 => 'Pending',
                                1 => 'Paid',
                                2 => 'On Its Way',
                                3 => 'Cancelled',
                                4 => 'Delivered',
                            ];

                            // Send email notification to customer
                            try {
                                $shipping = json_decode($record->shipping);
                                $customerEmail = $shipping->email ?? $record->user->email ?? null;

                                if ($customerEmail) {
                                    Mail::to($customerEmail)->send(new OrderStatusUpdatedMail($record, $oldStatus, $newStatus, $data['status_note'] ?? null));

                                    Notification::make()
                                        ->title('Order Status Updated')
                                        ->success()
                                        ->body("Status changed from {$statusNames[$oldStatus]} to {$statusNames[$newStatus]}. Email sent to customer.")
                                        ->send();
                                } else {
                                    Notification::make()
                                        ->title('Order Status Updated')
                                        ->success()
                                        ->body("Status changed from {$statusNames[$oldStatus]} to {$statusNames[$newStatus]}. No customer email found.")
                                        ->send();
                                }
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Status Updated (Email Failed)')
                                    ->warning()
                                    ->body("Status changed successfully, but email notification failed: " . $e->getMessage())
                                    ->send();
                            }
                        }),

                    // Bank Transfer Actions
                    Tables\Actions\Action::make('viewReceipt')
                        ->label('View Receipt')
                        ->icon('heroicon-o-document-magnifying-glass')
                        ->color('info')
                        ->visible(fn(Order $record) => $record->payment_method === 'bank_transfer' && $record->bank_transfer_receipt)
                        ->modalHeading('Payment Receipt')
                        ->modalContent(function (Order $record) {
                            $url = Storage::url($record->bank_transfer_receipt);
                            $extension = pathinfo($record->bank_transfer_receipt, PATHINFO_EXTENSION);

                            if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
                                return view('filament.modals.image-viewer', ['url' => $url]);
                            } else {
                                return view('filament.modals.pdf-viewer', ['url' => $url]);
                            }
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Close'),

                    Tables\Actions\Action::make('verifyPayment')
                        ->label('Verify Payment')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn(Order $record) => $record->payment_method === 'bank_transfer' && $record->bank_payment_status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('Verify Bank Transfer Payment')
                        ->modalDescription('Are you sure you want to mark this payment as verified? The customer will be notified via email.')
                        ->form([
                            Textarea::make('bank_payment_notes')
                                ->label('Notes (Optional)')
                                ->placeholder('Add any notes about the payment verification...')
                                ->rows(3),
                        ])
                        ->action(function (Order $record, array $data) {
                            $record->update([
                                'bank_payment_status' => 'verified',
                                'bank_payment_verified_at' => now(),
                                'bank_payment_verified_by' => auth()->id(),
                                'bank_payment_notes' => $data['bank_payment_notes'] ?? null,
                                'status' => 1, // Set order status to Paid
                                'payment_status' => 1, // Set payment status to Paid
                            ]);

                            // Send verification email to customer
                            $shipping = json_decode($record->shipping);
                            if ($shipping && isset($shipping->email)) {
                                Mail::to($shipping->email)->send(new BankTransferPaymentVerifiedMail($record));
                            }

                            Notification::make()
                                ->title('Payment Verified')
                                ->success()
                                ->body('The bank transfer payment has been verified and the customer has been notified.')
                                ->send();
                        }),

                    Tables\Actions\Action::make('rejectPayment')
                        ->label('Reject Payment')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(fn(Order $record) => $record->payment_method === 'bank_transfer' && $record->bank_payment_status === 'pending')
                        ->requiresConfirmation()
                        ->modalHeading('Reject Bank Transfer Payment')
                        ->modalDescription('Please provide a reason for rejecting this payment. The customer will be notified.')
                        ->form([
                            Textarea::make('bank_payment_notes')
                                ->label('Rejection Reason')
                                ->placeholder('Please explain why this payment is being rejected...')
                                ->required()
                                ->rows(4),
                        ])
                        ->action(function (Order $record, array $data) {
                            $record->update([
                                'bank_payment_status' => 'rejected',
                                'bank_payment_verified_at' => now(),
                                'bank_payment_verified_by' => auth()->id(),
                                'bank_payment_notes' => $data['bank_payment_notes'],
                                'status' => 3, // Set order status to Cancelled
                                'payment_status' => 0, // Set payment status to Unpaid

                            ]);

                            // Send rejection email to customer
                            $shipping = json_decode($record->shipping);
                            if ($shipping && isset($shipping->email)) {
                                Mail::to($shipping->email)->send(new BankTransferPaymentRejectedMail($record));
                            }

                            Notification::make()
                                ->title('Payment Rejected')
                                ->warning()
                                ->body('The bank transfer payment has been rejected and the customer has been notified.')
                                ->send();
                        }),


                ]),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->whereNull('parent_id')->latest();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'order-details' => Pages\OrderDetails::route('/{record}/details'),
        ];
    }
}
