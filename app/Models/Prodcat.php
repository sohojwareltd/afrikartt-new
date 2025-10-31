<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodcat extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function childrens()
    {
        return $this->hasMany(Prodcat::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Prodcat::class, 'parent_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'prodcat_product')
            ->withTimestamps();
    }


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
