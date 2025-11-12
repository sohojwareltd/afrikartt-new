<?php

namespace App\Models;

use App\Casts\ProductVarient;
use App\Casts\ProductVarient\Varient;
use App\Models\Traits\ShippingInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class Product extends Model
{
    use HasFactory, ShippingInfo;
    protected $guarded = [];

    protected $casts = [
        'images' => 'array',
        'variations' => ProductVarient::class,
        'parcels' => 'json',

    ];

    public $with = ['ratings'];

    public function getVariationBySku($sku)
    {
        return Varient::bySku($this, $sku);
    }


    public function getParcelsAttribute($value)
    {
        return json_decode($value, true);
    }


    protected static function boot()
    {
        parent::boot();

        static::saved(function ($product) {
            if ($product->isDirty('featured')) {
                Cache::forget('homepage_data');
            }
        });

        static::deleted(function ($product) {
            Cache::forget('homepage_data');
        });
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function discount()
    {
        $discount_amount  = $this->price - $this->sale_price;
        $discount_percantage = ($discount_amount / $this->price) * 100;
        return round($discount_percantage);
    }
    public function prodcats()
    {
        return $this->belongsToMany(Prodcat::class)->withTimestamps();
    }
    public function parentproduct()
    {
        return $this->belongsTo(Product::class, 'parent_id', 'id');
    }
    public function path()
    {
        return route('product', $this->slug);
    }

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }
    public function skus()
    {
        return $this->hasMany(Sku::class, 'product_id');
    }

    /**
     * Get the attribute values for this product.
     */
    public function attributeValues()
    {
        return $this->hasMany(ProductAttribureValue::class, 'product_id');
    }

    public function subproducts()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }

    public function subproductsuser()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id')->where('price', '>', 0)->whereNotNull('variations');
    }


    public function scopePrice($query)
    {
        return $query->where('price', '!=', null);
    }

    public function scopeFilter($query)
    {

        //new
        return $query
            ->when(request()->filled('category'), function ($q) {
                return $q->whereHas('prodcats', function ($query) {
                    $query->where('slug', request()->category);
                });
            })
            ->when(request()->has('search'), function ($q) {
                return $q->where(function ($query) {
                    $search = request()->search;

                    $query->where('name', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('short_description', 'LIKE', '%' . request()->search . '%')
                        ->orWhere('search_keywords', 'LIKE', "%{$search}%")
                    ;
                });
            })
            ->when(request()->has('featured'), function ($q) {
                return $q->where('featured', 1);
            })
            ->when(request()->has('shop'), function ($q) {
                if (is_numeric(request()->shop)) {

                    return $q->whereHas('shop', function ($query) {
                        $query->where('shop_id', request()->shop);
                    });
                } else {

                    return $q->whereHas('shop', function ($query) {
                        $query->where('name', request()->shop);
                    });
                }
            })
            ->when(
                request()->has('ratings'),
                function ($q) {
                    return  $q->whereHas('ratings', function ($q) {
                        $q->where('rating', request()->ratings);
                    });
                }
            )

            ->when(request()->has('filter_products') && request()->filter_products == 'price-low-high', function ($q) {
                return $q->orderBy('price', 'asc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'price-high-low', function ($q) {
                return $q->orderBy('price', 'desc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'most-popular', function ($q) {
                return $q->orderBy('total_sale', 'desc');
            })
            ->when(request()->has('filter_products') && request()->filter_products == 'trending', function ($q) {
                return $q->orderBy('views', 'desc');
            })
            ->when(request('priceMin') && request('priceMax'), function ($q) {
                return $q->whereBetween('price', [request('priceMin'), request('priceMax')]);
            })
            ->when(Session::has('post_city'), function ($q) {
                $post_city = Session::get('post_city');
                return $q->whereHas('shop', function ($qr) use ($post_city) {
                    $qr->where(function ($qp) use ($post_city) {
                        $qp->whereIn('city', $post_city);
                    });
                });
            })->when(Session::has('state'), function ($q) {
                $state = Session::get('state');
                return $q->whereHas('shop', function ($qr) use ($state) {
                    $qr->where('state', 'like', '%' . $state . '%');
                });
            });
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class)->latest();
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getImagesAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    /**
     * Get a specific variation by index
     */
    public function getVariation($index)
    {
        if (isset($this->variations[$index])) {
            return $this->variations[$index];
        }
        return null;
    }

    /**
     * Update a specific variation and save
     */
    public function updateVariation($index, $data)
    {
        if (isset($this->variations[$index])) {
            $variation = $this->variations[$index];
            foreach ($data as $key => $value) {
                $variation->$key = $value;
            }
            $this->save();
            return true;
        }
        return false;
    }

    public function getPrice()
    {
        return $this->sale_price ?? $this->price;
    }
    public function scopeCountry(Builder $query, $country = null)
    {
        $country = $country ?? Session::get('myCountry.name');

        if ($country) {
            $query->whereHas('shop', function ($q) use ($country) {
                $q->where('country', $country);
            });
        }

        return $query;
    }
    public function scopeSearchKeywords(Builder $query, string $keywords): Builder
    {
        return $query->when($keywords, function ($q) use ($keywords) {
            $terms = preg_split('/\s+/', trim($keywords));
            foreach ($terms as $term) {
                $q->orWhere('search_keywords', 'LIKE', "%{$term}%");
            }
        });
    }
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'product_user_wishlist')
            ->withTimestamps();
    }
}