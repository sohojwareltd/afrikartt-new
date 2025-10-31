<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\OrderResource\Pages;
use App\Filament\Vendor\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-circle';

    protected static ?string $navigationGroup = 'Orders';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('shop_id', Auth::user()->shop->id);
    }

    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }
    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->relationship('user', 'name')->searchable()->nullable(),
                Select::make('shop_id')->relationship('shop', 'name')->searchable()->nullable(),
                Select::make('product_id')->relationship('product', 'name')->searchable()->nullable(),

                Select::make('status')
                    ->options([
                        0 => 'Pending',
                        1 => 'Paid',
                        2 => 'On Its Way',
                        3 => 'Cancelled',
                        4 => 'Delivered',
                    ])
                    ->default(0)
                    ->required(),

                TextInput::make('currency')->maxLength(5)->nullable(),
                TextInput::make('discount')->numeric()->nullable(),
                TextInput::make('discount_code')->nullable(),
                TextInput::make('shipping_total')->numeric()->nullable(),
                TextInput::make('shipping_method')->nullable(),
                TextInput::make('shipping_url')->nullable(),

                TextInput::make('subtotal')->required()->numeric(),
                TextInput::make('total')->required()->numeric(),
                TextInput::make('vendor_total')->required()->numeric(),
                TextInput::make('tax')->nullable()->numeric(),

                Toggle::make('seen')->default(false),
                Toggle::make('order_accept')->label('Accepted')->default(false),

                TextInput::make('customer_note')->nullable(),
                // KeyValue::make('billing')->nullable(),
                // KeyValue::make('shipping')->required(),

                TextInput::make('payment_method')->nullable(),
                TextInput::make('payment_method_title')->nullable(),
                TextInput::make('transaction_id')->nullable(),

                DatePicker::make('date_paid')->nullable(),
                DatePicker::make('date_completed')->nullable(),

                TextInput::make('refund_amount')->nullable(),
                TextInput::make('company')->nullable(),
                TextInput::make('aptment')->nullable(),
                TextInput::make('quantity')->required()->numeric(),

                Textarea::make('return_reason')->nullable(),
                FileUpload::make('return_file')->directory('returns')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->toggleable(),
                TextColumn::make('user.name')->label('Customer')->sortable()->searchable()->toggleable(),
                TextColumn::make('shop.name')->label('Shop')->sortable()->searchable()->toggleable(),
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
                TextColumn::make('vendor_total')->money('USD')->sortable()->toggleable(),
                // BooleanColumn::make('seen')->toggleable(),
                // BooleanColumn::make('order_accept')->label('Accepted')->toggleable(),
                TextColumn::make('created_at')->dateTime('F j, Y')->toggleable(),
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
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    // Tables\Actions\EditAction::make(),
                    // Tables\Actions\DeleteAction::make(),
                    Tables\Actions\Action::make('orderDetails')
                        ->label('Order Details')
                        ->icon('heroicon-o-document-text')
                        ->url(fn($record) => route('filament.vendor.resources.orders.order-details', ['record' => $record])),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'order-details' => Pages\OrderDetails::route('/{record}/details'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        // TEMPORARILY DISABLED FOR DEBUGGING
        return null;

        try {
            $user = Auth::user();
            if (!$user || !$user->shop) {
                return null;
            }

            // DIRECT QUERY - DON'T USE getEloquentQuery()
            $count = \App\Models\Order::where('shop_id', $user->shop->id)->count();
            return $count > 0 ? (string) $count : null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
