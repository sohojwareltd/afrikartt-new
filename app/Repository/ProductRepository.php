<?php

namespace App\Repository;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class ProductRepository
{

    protected $select = ['id', 'slug', 'name', 'shop_id', 'views', 'post_code', 'status', 'parent_id', 'images', 'image', 'price', 'sale_price'];
    protected $relations = [
        'shop:id,name,status,slug',
        'ratings:id,product_id,rating',
        'prodcats:id,name,slug'
    ];
    protected $locationPostcodes;
    protected $recommend;

    public function __construct()
    {
        $this->locationPostcodes = Session::get('location.postcode', []);
        $this->recommend = Session::get('recommend', []);
    }

    public static function getLatestProducts(int $limit = 12)
    {
        return (new self())->latestProducts($limit);
    }

    public  function latestProducts(int $limit = 12)
    {

        $locationPostcodes = $this->locationPostcodes;
        return Cache::remember('latest_products_' . md5(json_encode($locationPostcodes)) . '_' . $limit, 300, function () use ($locationPostcodes, $limit) {
            return Product::query()
                ->select($this->select)
                ->where('status', 1)
                ->whereHas('shop', fn($q) => $q->where('status', 1))
                // ->when(!empty($locationPostcodes), fn($q) => $q->whereIn('post_code', $locationPostcodes))
                ->orderByDesc('views')
                ->country()
                ->latest()
                ->limit($limit)
                ->with($this->relations)
                ->price()
                ->orderByDesc('views')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    public static function getBestsaleProducts(int $limit = 12)
    {
        return (new self())->bestsaleProducts($limit);
    }

    public  function bestsaleProducts(int $limit = 12)
    {
        $locationPostcodes = $this->locationPostcodes;
        return   Cache::remember('bestsaleproducts:' . md5(json_encode($locationPostcodes)) . '_' . $limit, 3600, function () use ($locationPostcodes, $limit) {

            return Product::query()
                ->select($this->select)
                ->where('status', 1)
                ->whereNull('parent_id')
                ->whereHas('shop', fn($q) => $q->where('status', 1))
                // ->when(!empty($locationPostcodes), fn($q) => $q->whereIn('post_code', $locationPostcodes))
                ->orderByDesc('total_sale')
                ->country()
                ->latest()
                ->limit($limit)
                ->with($this->relations)
                ->price()
                ->orderByDesc('total_sale')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    public static function getRecommendProducts(int $limit = 12)
    {
        return (new self())->recommendProducts($limit);
    }

    public  function recommendProducts(int $limit = 12)
    {
        $recommend = $this->recommend;
        return  Cache::remember('recommendProducts:' . md5(json_encode($recommend)) . '_' . $limit, 3600, function () use ($recommend, $limit) {
            return Product::query()
                ->select($this->select)
                ->country()
                ->whereNull('parent_id')
                ->whereIn('id', $recommend)
                ->with($this->relations)
                ->limit($limit)
                ->price()
                ->orderByDesc('id')
                ->latest()
                ->limit($limit)
                ->get();
        });
    }

    public static function getAllProducts(int $paginate = 24)
    {
        return (new self())->allProducts($paginate);
    }

    public function allProducts(int $paginate = 12)
    {
        return Product::where("status", 1)->country()->whereNull('parent_id')->whereHas('shop', function ($q) {
            $q->where('status', 1);
        })->filter()->price()->paginate($paginate);
    }
    public static function getShowcaseProducts(int $limit = 12)
    {
        return (new self())->showcaseProducts($limit);
    }
    public function showcaseProducts(int $limit = 12)
    {
        return Product::where("status", 1)->country()->whereNull('parent_id')->whereHas('shop', function ($q) {
            $q->where('status', 1);
        })->filter()->price()->inRandomOrder()->limit($limit)->get();
    }
    public static function getVendorProducts(Shop $shop, array $filters = [])
    {
        return Product::where("status", 1)->whereNull('parent_id')->whereHas('shop', function ($q) {
            $q->where('status', 1);
        })->filter()->price()->paginate(12);
    }
}