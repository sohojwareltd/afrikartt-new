<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAttribureValue extends Model
{
    protected $table = 'product_attribute_value';

    protected $fillable = [
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
}
