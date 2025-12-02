<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        $this->clearProductCaches($product);

        Log::info('Product created, caches cleared', [
            'product_id' => $product->id,
            'product_name' => $product->name
        ]);
    }

    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        $this->clearProductCaches($product);

        Log::info('Product updated, caches cleared', [
            'product_id' => $product->id,
            'product_name' => $product->name
        ]);
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        $this->clearProductCaches($product);

        Log::info('Product deleted, caches cleared', [
            'product_id' => $product->id,
            'product_name' => $product->name
        ]);
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        $this->clearProductCaches($product);

        Log::info('Product restored, caches cleared', [
            'product_id' => $product->id,
            'product_name' => $product->name
        ]);
    }

    /**
     * Clear all product-related caches
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    protected function clearProductCaches(Product $product)
    {
        // 1. Clear homepage cache (main requirement)
        Cache::forget('homepage_data');

        // 2. Clear product repository caches with wildcard patterns
        // Note: These use dynamic keys with location/session data, so we flush patterns
        $this->clearCachePattern('latest_products_');
        $this->clearCachePattern('bestsaleproducts:');
        $this->clearCachePattern('recommandProducts:');

        // 3. Clear category caches (products are linked to categories)
        Cache::forget('prodcats');
        Cache::forget('prodcats_parent');

        // 4. Clear shop-related caches (products belong to shops)
        $this->clearCachePattern('latest_shops_');
        Cache::forget('header_shops');

        // 5. Clear header categories cache (may include product counts)
        Cache::forget('header_categories');

        // 6. Additional cache keys that might be affected
        // Uncomment if you have these cache keys in your application:
        // Cache::forget('featured_products');
        // Cache::forget('trending_products');
        // Cache::forget('popular_categories');
        // Cache::forget('shop_' . $product->shop_id . '_products');
    }

    /**
     * Clear cache keys matching a pattern
     * Note: This works for Redis/Memcached drivers with prefix support
     * For file cache, this will only work if you implement custom logic
     *
     * @param  string  $pattern
     * @return void
     */
    protected function clearCachePattern(string $pattern)
    {
        try {
            // For Redis cache driver
            if (Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                $redis = Cache::getStore()->connection();
                $prefix = Cache::getStore()->getPrefix();
                $keys = $redis->keys($prefix . $pattern . '*');

                if (!empty($keys)) {
                    foreach ($keys as $key) {
                        // Remove prefix before deleting
                        $key = str_replace($prefix, '', $key);
                        Cache::forget($key);
                    }
                }
            } else {
                // For file/array cache, we can't easily pattern match
                // So we'll just flush all cache (be careful in production)
                // Alternative: maintain a list of known cache keys
                Log::warning('Cache driver does not support pattern matching. Consider using Redis for better cache management.');

                // Option 1: Flush all cache (use with caution)
                // Cache::flush();

                // Option 2: Clear known cache keys manually (safer)
                // This is already handled in clearProductCaches method above
            }
        } catch (\Exception $e) {
            Log::error('Error clearing cache pattern: ' . $pattern, [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Alternative method: Force clear all product-related caches
     * Use this if pattern matching doesn't work for your cache driver
     * 
     * @return void
     */
    protected function forceFlushProductCaches()
    {
        // Clear specific known cache keys
        $cacheKeys = [
            'homepage_data',
            'prodcats',
            'prodcats_parent',
            'header_categories',
            'header_shops',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // If you need to clear ALL caches (use with extreme caution in production)
        // Cache::flush();
    }
}
