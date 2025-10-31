<?php

namespace App\Casts\ProductVarient;

use App\Models\Product;

class Varient
{
    private $product;
    private $variationIndex;
    private $variationData;

    public function __construct($attributes, Product $product, $variationIndex = null)
    {
        $this->product = $product;
        $this->variationIndex = $variationIndex;
        $this->variationData = $attributes;
    }

    // Magic getter to access variation data
    public function __get($name)
    {
        if (isset($this->variationData[$name])) {
            return $this->variationData[$name];
        }
        return null;
    }

    // Magic setter to modify the original product variations array
    public function __set($name, $value)
    {
        $this->variationData[$name] = $value;
        
        // Update the original product variations array
        if ($this->variationIndex !== null) {
            $variations = $this->product->getRawOriginal('variations');
            if (is_string($variations)) {
                $variations = json_decode($variations, true);
            }
            
            if (is_array($variations) && isset($variations[$this->variationIndex])) {
                $variations[$this->variationIndex][$name] = $value;
                $this->product->setAttribute('variations', $variations);
            }
        }

        $this->product->save();
    }

    // Magic isset to check if property exists
    public function __isset($name)
    {
        return isset($this->variationData[$name]);
    }

    // Convenience methods for common properties
    public function getSku()
    {
        return $this->variationData['sku'] ?? null;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    public function getPrice()
    {
        return $this->variationData['price'] ?? 0;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getStock()
    {
        return $this->variationData['stock'] ?? 0;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
        $this->product->save();
    }

    public function getAttributes()
    {
        return $this->variationData['attributes'] ?? [];
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    public function decreaseStock($quantity = 1)
    {
        $currentStock = $this->getStock();
        $this->setStock($currentStock - $quantity);
    }

    public function increaseStock($quantity = 1)
    {
        $currentStock = $this->getStock();
        $this->setStock($currentStock + $quantity);
    }

    public static function bySku(Product $product, $sku)
    {
        $variations = $product->variations;
        foreach ($variations as $index => $variation) {
            if ($variation->sku === $sku) {
                return $variation;
            }
        }
        return null;
    }

    // Method to get the raw variation data
    public function toArray()
    {
        return $this->variationData;
    }

    // Method to save changes to the product
    public function save()
    {
        return $this->product->save();
    }

    // Method to check if this variation is in stock
    public function isInStock()
    {
        return $this->getStock() > 0;
    }

    // Method to check if this variation has sufficient stock
    public function hasStock($quantity)
    {
        return $this->getStock() >= $quantity;
    }

    // Method to get formatted price
    public function getFormattedPrice()
    {
        return '$' . number_format($this->getPrice(), 2);
    }

    // Method to get formatted compare price
    public function getFormattedComparePrice()
    {
        return '$' . number_format($this->compare_at_price, 2);
    }

    // Method to check if this variation has a discount
    public function hasDiscount()
    {
        return $this->compare_at_price > 0 && $this->compare_at_price > $this->price;
    }

    // Method to get discount percentage
    public function getDiscountPercentage()
    {
        if ($this->hasDiscount()) {
            return round((($this->compare_at_price - $this->price) / $this->compare_at_price) * 100);
        }
        return 0;
    }

    // Method to get stock status badge class
    public function getStockBadgeClass()
    {
        if (!$this->track_quantity) {
            return 'bg-info';
        }
        
        if ($this->stock > 10) {
            return 'bg-success';
        } elseif ($this->stock > 0) {
            return 'bg-warning';
        } else {
            return 'bg-danger';
        }
    }

    // Method to get stock display text
    public function getStockDisplayText()
    {
        if (!$this->track_quantity) {
            return 'Unlimited';
        }
        return $this->stock . ' in stock';
    }
}
