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
}
