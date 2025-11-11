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
        'title',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
    ];

    /**
     * Get the product that owns the SKU.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}