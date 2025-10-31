<?php

namespace App\Filament\Vendor\Resources;

use App\Filament\Vendor\Resources\ShopPoliciesResource\Pages;
use App\Filament\Vendor\Resources\ShopPoliciesResource\RelationManagers;
use App\Models\ShopPolicies;
use App\Models\ShopPolicy;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShopPoliciesResource extends Resource
{
    protected static ?string $model = ShopPolicy::class;
    public static ?string $label = "Shop Policy";
    public static ?string $title = "Shop Policy";

    public static ?string $navigationGroup = 'Profile';
    public static ?string $description = "Manage your shop policies here.";



    public static function getEloquentQuery(): Builder
    {
        $shop = auth()->user()->shop;
        return parent::getEloquentQuery()
            ->where('shop_id', $shop->id); // assuming vendor has `shop_id`
    }
    public static function shouldRegisterNavigation(): bool
    {
        if (auth()->check()) {
            $shop = auth()->user()->shop;
            return $shop && $shop->status == 1;
        }
        return false;
    }


    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShopPolicies::route('/'),
        ];
    }
}
