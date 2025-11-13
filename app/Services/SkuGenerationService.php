<?php

namespace App\Services;

use App\Models\FilamentProduct;
use App\Models\ProductAttribureValue;
use App\Models\Sku;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SkuGenerationService
{
    /**
     * Generate all SKU combinations for a product based on its attribute values.
     *
     * @param FilamentProduct $product
     * @return array Array of created SKU IDs
     */
    public function generateSkus(FilamentProduct $product): array
    {
        // Get all attribute values for this product
        $attributeValues = $product->attributeValues()->with('attribute')->get();

        if ($attributeValues->isEmpty()) {
            // Delete only auto-generated SKUs if no attribute values (preserve manual SKUs)
            $product->skus()->where('is_manual', false)->delete();
            return [];
        }

        // Group attribute values by attribute_id
        $groupedAttributes = $attributeValues->groupBy('attribute_id');

        // Need at least one attribute to generate combinations
        if ($groupedAttributes->isEmpty()) {
            return [];
        }

        // Generate all combinations
        $combinations = $this->generateCombinations($groupedAttributes);

        if (empty($combinations)) {
            return [];
        }

        $createdSkuIds = [];

        DB::transaction(function () use ($product, $combinations, &$createdSkuIds) {
            // Load existing SKUs with their attribute combinations
            $existingSkus = $product->skus()->with('attributeValues')->get();

            $existingSkuMap = [];

            foreach ($existingSkus as $existingSku) {
                $attributeValueIds = $existingSku->attributeValues
                    ->pluck('id')
                    ->sort()
                    ->values()
                    ->all();

                $key = $this->buildCombinationKey($attributeValueIds);
                $existingSkuMap[$key] = $existingSku;
            }

            // Create missing combinations
            foreach ($combinations as $combination) {
                sort($combination);
                $key = $this->buildCombinationKey($combination);

                if (isset($existingSkuMap[$key])) {
                    // Combination already exists, skip creation and mark as processed
                    unset($existingSkuMap[$key]);
                    continue;
                }

                $sku = $this->createSku($product, $combination);
                $createdSkuIds[] = $sku->id;
            }

            // Delete auto-generated SKUs that no longer have a matching combination
            foreach ($existingSkuMap as $remainingSku) {
                if (!$remainingSku->is_manual) {
                    $remainingSku->delete();
                }
            }
        });

        return $createdSkuIds;
    }

    /**
     * Generate all combinations from grouped attributes.
     *
     * @param \Illuminate\Support\Collection $groupedAttributes
     * @return array
     */
    protected function generateCombinations($groupedAttributes): array
    {
        if ($groupedAttributes->isEmpty()) {
            return [];
        }

        // Convert to arrays of attribute value IDs
        $attributeGroups = $groupedAttributes->map(function ($group) {
            return $group->pluck('id')->toArray();
        })->values()->toArray();

        // Generate Cartesian product
        $combinations = $this->cartesianProduct($attributeGroups);

        return $combinations;
    }

    /**
     * Calculate the Cartesian product of multiple arrays.
     *
     * @param array $arrays
     * @return array
     */
    protected function cartesianProduct(array $arrays): array
    {
        if (empty($arrays)) {
            return [[]];
        }

        $result = [];
        $firstArray = array_shift($arrays);
        $restProduct = $this->cartesianProduct($arrays);

        foreach ($firstArray as $item) {
            foreach ($restProduct as $rest) {
                $result[] = array_merge([$item], $rest);
            }
        }

        return $result;
    }

    /**
     * Create a SKU record for a combination of attribute values.
     *
     * @param FilamentProduct $product
     * @param array $attributeValueIds
     * @return Sku
     */
    protected function createSku(FilamentProduct $product, array $attributeValueIds): Sku
    {
        // Load attribute values with their attributes
        $attributeValues = ProductAttribureValue::whereIn('id', $attributeValueIds)
            ->with('attribute')
            ->get();

        // Generate SKU code
        $skuCode = $this->generateSkuCode($product, $attributeValues);

        // Generate title
        $title = $this->generateTitle($attributeValues);

        // Get default price from product
        $defaultPrice = $product->sale_price ?? $product->price ?? 0;
        $defaultCompareAtPrice = $product->price ?? $defaultPrice;

        // Create SKU (auto-generated, not manual)
        $sku = Sku::create([
            'product_id' => $product->id,
            'sku' => $skuCode,
            'price' => $defaultPrice,
            'compare_at_price' => $defaultCompareAtPrice,
            'quantity' => 0,
            'title' => $title,
            'is_manual' => false,
        ]);

        // Attach attribute values to SKU
        $sku->attributeValues()->attach($attributeValueIds);

        return $sku;
    }

    /**
     * Build a unique key for a combination of attribute value IDs.
     *
     * @param array $attributeValueIds
     * @return string
     */
    protected function buildCombinationKey(array $attributeValueIds): string
    {
        if (empty($attributeValueIds)) {
            return 'base';
        }

        return implode('-', $attributeValueIds);
    }

    /**
     * Generate a unique SKU code for a combination.
     *
     * @param FilamentProduct $product
     * @param \Illuminate\Database\Eloquent\Collection $attributeValues
     * @return string
     */
    protected function generateSkuCode(FilamentProduct $product, $attributeValues): string
    {
        $baseSlug = $product->slug ?? Str::slug($product->name);
        
        // Get values for SKU code (use slugified versions)
        $valueParts = $attributeValues->map(function ($attrValue) {
            // Use getDisplayName() which handles JSON for image type
            return Str::slug($attrValue->getDisplayName());
        })->toArray();

        $skuCode = $baseSlug . '-' . implode('-', $valueParts);

        // Ensure uniqueness
        $originalSkuCode = $skuCode;
        $counter = 1;
        while (Sku::where('sku', $skuCode)->exists()) {
            $skuCode = $originalSkuCode . '-' . $counter;
            $counter++;
        }

        return $skuCode;
    }

    /**
     * Generate a human-readable title for a combination.
     *
     * @param \Illuminate\Database\Eloquent\Collection $attributeValues
     * @return string
     */
    protected function generateTitle($attributeValues): string
    {
        $parts = $attributeValues->map(function ($attrValue) {
            // Use getDisplayName() which handles JSON for image type
            return $attrValue->getDisplayName();
        })->toArray();

        return implode(' - ', $parts);
    }
}

