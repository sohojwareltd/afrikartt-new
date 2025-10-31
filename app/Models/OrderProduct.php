<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table = 'order_product';

    protected $guarded = [];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variation() : Attribute
    {
        return Attribute::make(
            set : fn($value) => json_encode($value)
        );
    }
}
