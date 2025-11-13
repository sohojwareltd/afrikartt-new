<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'compare_at_price',
        'quantity',
        'title',
        'image',
        'is_manual',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_manual' => 'boolean',
    ];

    /**
     * Get the product that owns the SKU.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the FilamentProduct that owns the SKU.
     */
    public function filamentProduct()
    {
        return $this->belongsTo(FilamentProduct::class, 'product_id');
    }

    /**
     * Get the attribute values for this SKU.
     */
    public function attributeValues()
    {
        return $this->belongsToMany(ProductAttribureValue::class, 'sku_attributes', 'sku_id', 'product_attribute_value_id')
            ->withTimestamps();
    }

    /**
     * Get a formatted string of attribute labels for this SKU.
     */
    public function getAttributeLabelsAttribute(): string
    {
        return $this->attributeValues()
            ->with('attribute')
            ->get()
            ->map(function ($attrValue) {
                $attrName = $attrValue->attribute->name ?? '';
                $value = $attrValue->getDisplayName();
                return "{$attrName}: {$value}";
            })
            ->implode(', ');
    }

    /**
     * Get attribute labels as HTML.
     */
    public function getAttributeLabelsHtml(): string
    {
        return $this->attributeValues()
            ->with('attribute')
            ->get()
            ->map(function ($attrValue) {
                $attrName = $attrValue->attribute->name ?? '';
                if ($attrValue->type === 'image') {
                    $imagePath = $attrValue->getImagePath();
                    $displayName = $attrValue->getDisplayName();
                    $imageUrl = $imagePath ? asset('storage/' . $imagePath) : '';
                    $value = $imageUrl 
                        ? '<img src="' . $imageUrl . '" class="inline-block w-8 h-8 rounded" alt="' . htmlspecialchars($displayName) . '" title="' . htmlspecialchars($displayName) . '" />'
                        : htmlspecialchars($displayName);
                } else {
                    $value = htmlspecialchars($attrValue->getDisplayName());
                }
                return "<strong>{$attrName}:</strong> {$value}";
            })
            ->implode('<br>');
    }
}