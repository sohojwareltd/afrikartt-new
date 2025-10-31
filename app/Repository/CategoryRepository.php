<?php

namespace App\Repository;

use App\Models\Prodcat;
use Illuminate\Support\Facades\Cache;

class CategoryRepository
{
    public static function getAllCategoriesWithProducts()
    {
        return (new self())->allCategoriesWithProducts();
    }

    public static function getAllParentCategories()
    {
        return (new self())->allParentCategories();
    }

    public  function allCategoriesWithProducts()
    {
        return Cache::remember('prodcats', 300, function () {
            return Prodcat::with(['childrens:id,name,slug,parent_id'])
                ->whereNull('parent_id')
                ->whereHas('products')
                ->orderBy('role', 'asc')
                ->get();
        });
    }

    public  function allParentCategories()
    {
        return Cache::remember('prodcats_parent', 3600, function () {
            return Prodcat::has('products')->whereNull('parent_id')->latest()->get();
        });
    }
}
