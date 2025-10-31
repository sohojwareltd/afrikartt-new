<?php

namespace App\Repository;

use App\Models\Shop;
use Illuminate\Support\Facades\Cache;

class ShopRepsitory
{
    protected $relations = [
        'products:id,name,shop_id,slug,images,views,image,sale_price,price,post_code,status',
        'products.ratings:id,product_id,rating',
        'products.prodcats:id,name,slug'
    ];
    public static function getLatestShops(int $limit = 8)
    {
        return (new self())->latestShops($limit);
    }

    public  function latestShops(int $limit = 8)
    {
        return Cache::remember('latest_shops_' . $limit, 300, function () use ($limit) {
            return Shop::query()
                ->where('status', 1)
                ->country()
                ->whereHas('products', fn($q) => $q->whereNull('parent_id'))
                ->latest()
                ->limit($limit)
                ->with($this->relations)
                ->get();
        });
    }
}
