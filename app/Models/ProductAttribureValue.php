<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribureValue extends Model
{
    protected $table = 'product_attribute_value';

    protected $fillable = [
        'product_id',
        'attribute_id',
        'type',
        'value',
    ];

    protected $casts = [
        'type' => 'string',
    ];


    /**
     * Get the attribute that owns the value.
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    /**
     * Get the product that owns this attribute value.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(FilamentProduct::class, 'product_id');
    }

    /**
     * Get SKUs that use this attribute value.
     */
    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'sku_attributes', 'product_attribute_value_id', 'sku_id');
    }

    /**
     * Get the display name for this attribute value.
     * For image type, returns the name from JSON if available, otherwise filename.
     * For text type, returns the value as-is.
     */
    public function getDisplayName(): string
    {
        if ($this->type === 'image') {
            $value = $this->value;
            
            // Try to decode as JSON
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded['name'])) {
                    return $decoded['name'];
                }
            }
            
            // Fallback to filename for backward compatibility
            return pathinfo($value, PATHINFO_FILENAME);
        }
        
        return $this->value ?? '';
    }

    /**
     * Get the image path for image type attributes.
     */
    public function getImagePath(): ?string
    {
        if ($this->type !== 'image') {
            return null;
        }
        
        $value = $this->value;
        
        // Try to decode as JSON
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && isset($decoded['image_path'])) {
                return $decoded['image_path'];
            }
        }
        
        // Fallback to value itself for backward compatibility
        return $value;
    }
}
