<?php

namespace App\View\Components\Products;

use App\Models\Product as ProductModel;
use App\Facade\Sohoj;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class Product extends Component
{
    public ProductModel $product;
    public bool $showMultipleCategories;
    public float $averageRating;
    public int $ratingCount;
    public float|int|null $currentPrice;
    public float|int|null $originalPrice;
    public bool $hasDiscount;
    public int $discountPercentage;
    public int $fullStars;
    public bool $hasHalfStar;
    public bool $isVariableProduct;
    public bool $hasVariations;
    public array $variationPrices;
    public bool $isInWishlist;

    /**
     * Create a new component instance.
     */
    public function __construct(ProductModel $product, bool $showMultipleCategories = true, string $variant = 'default')
    {
        $this->product = $product;
        $this->showMultipleCategories = $showMultipleCategories;
        
        // Initialize all properties with default values first
        $this->initializeDefaults();
        
        try {
            $this->calculateRatingData();
            $this->calculatePricingData();
            $this->calculateWishlistStatus();
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Product component error: ' . $e->getMessage(), [
                'product_id' => $this->product->id ?? 'unknown',
                'product_name' => $this->product->name ?? 'unknown'
            ]);
        }
    }
    
    /**
     * Initialize all properties with safe default values
     */
    private function initializeDefaults(): void
    {
        $this->averageRating = 0.0;
        $this->ratingCount = 0;
        $this->currentPrice = null;
        $this->originalPrice = null;
        $this->hasDiscount = false;
        $this->discountPercentage = 0;
        $this->fullStars = 0;
        $this->hasHalfStar = false;
        $this->isVariableProduct = false;
        $this->hasVariations = false;
        $this->variationPrices = [];
        $this->isInWishlist = false;
    }

    /**
     * Calculate rating related data
     */
    private function calculateRatingData(): void
    {
        try {
            $sohoj = new Sohoj();
            $this->averageRating = $sohoj->average_rating($this->product->ratings ?? collect());
            $this->ratingCount = $this->product->ratings->count() ?? 0;
            $this->fullStars = floor($this->averageRating);
            $this->hasHalfStar = $this->averageRating - $this->fullStars >= 0.5;
        } catch (\Exception $e) {
            // Fallback values if rating calculation fails
            $this->averageRating = 0.0;
            $this->ratingCount = 0;
            $this->fullStars = 0;
            $this->hasHalfStar = false;
        }
    }

    /**
     * Calculate pricing related data
     */
    private function calculatePricingData(): void
    {
        try {
            $this->isVariableProduct = (bool) ($this->product->is_variable_product ?? false);
            $this->hasVariations = $this->isVariableProduct && 
                                   isset($this->product->variations) && 
                                   is_array($this->product->variations) && 
                                   count($this->product->variations) > 0;

            if ($this->hasVariations) {
                $this->calculateVariableProductPricing();
            } else {
                $this->calculateRegularProductPricing();
            }
        } catch (\Exception $e) {
            // Fallback values if pricing calculation fails
            $this->isVariableProduct = false;
            $this->hasVariations = false;
            $this->currentPrice = null;
            $this->originalPrice = null;
            $this->hasDiscount = false;
            $this->discountPercentage = 0;
        }
    }

    /**
     * Calculate pricing for variable products
     */
    private function calculateVariableProductPricing(): void
    {
        $this->variationPrices = collect($this->product->variations)
            ->map(function ($variation) {
                return $variation->price ?? 0;
            })
            ->filter(function ($price) {
                return $price > 0;
            })
            ->toArray();

        if (!empty($this->variationPrices)) {
            $minPrice = min($this->variationPrices);
            $this->currentPrice = $minPrice > 0 ? $minPrice : null;
            $this->originalPrice = $this->currentPrice;
            $this->hasDiscount = false;
            $this->discountPercentage = 0;
        } else {
            $this->calculateRegularProductPricing();
        }
    }

    /**
     * Calculate pricing for regular products
     */
    private function calculateRegularProductPricing(): void
    {
        $salePrice = $this->product->sale_price ?? null;
        $regularPrice = $this->product->price ?? null;
        
        $this->currentPrice = $salePrice ?? $regularPrice;
        $this->originalPrice = $regularPrice;
        
        $this->hasDiscount = $salePrice && $regularPrice && $salePrice < $regularPrice;
        $this->discountPercentage = $this->hasDiscount && $this->originalPrice > 0
            ? round((($this->originalPrice - $this->currentPrice) / $this->originalPrice) * 100) 
            : 0;
    }

    /**
     * Calculate wishlist status
     */
    private function calculateWishlistStatus(): void
    {
        try {
            $wishlist = session()->get('wishlist', []);
            $this->isInWishlist = in_array($this->product->id ?? 0, $wishlist);
        } catch (\Exception $e) {
            $this->isInWishlist = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.product', [
            'product' => $this->product,
            'showMultipleCategories' => $this->showMultipleCategories,
            'averageRating' => $this->averageRating,
            'ratingCount' => $this->ratingCount,
            'currentPrice' => $this->currentPrice,
            'originalPrice' => $this->originalPrice,
            'hasDiscount' => $this->hasDiscount,
            'discountPercentage' => $this->discountPercentage,
            'fullStars' => $this->fullStars,
            'hasHalfStar' => $this->hasHalfStar,
            'isVariableProduct' => $this->isVariableProduct,
            'hasVariations' => $this->hasVariations,
            'variationPrices' => $this->variationPrices,
            'isInWishlist' => $this->isInWishlist,
        ]);
    }
}
