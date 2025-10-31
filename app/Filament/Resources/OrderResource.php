<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
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
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;
        
        return static::$model::count();
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
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-user')
                    ->toggleable(),
                TextColumn::make('shop.name')
                    ->label('Shop')
                    ->sortable()
                    ->searchable()
                    ->icon('heroicon-o-building-storefront')
                    ->toggleable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'On Its Way',
                        3 => 'Cancelled',
                        4 => 'Delivered',
                        default => 'Unknown',
                    })
                    ->color(fn($state) => match ($state) {
                        0 => 'secondary',
                        1 => 'success',
                        2 => 'warning',
                        3 => 'danger',
                        4 => 'primary',
                        default => 'gray',
                    })
                    ->icon(fn($state) => match ($state) {
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
                    ->formatStateUsing(fn($state) => match ($state) {
                        0 => 'Pending',
                        1 => 'Paid',
                    })
                    ->color(fn($state) => match ($state) {
                        0 => 'danger',
                        1 => 'success',
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
