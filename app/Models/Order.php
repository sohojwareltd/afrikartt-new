<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $guarded = [];
    // protected $casts = [
    //     'billing' => 'array',
    //     'shipping' => 'array',
    //     'seen' => 'boolean',
    //     'order_accept' => 'boolean',
    //     'date_paid' => 'datetime',
    //     'date_completed' => 'datetime',
    // ];
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->belongsToMany(Product::class)->withTimestamps()->withPivot(['variation','quantity','price','total_price']);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function childs()
    {
        return $this->hasMany(Order::class, 'parent_id');
    }

    public function parent(){
        return $this->belongsTo(Order::class,'parent_id');
    }
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'order_id');
    }
    public function getFirstNameAttribute()
    {
        return json_decode($this->shipping)?->first_name ?? json_decode($this->shipping)->firstName;
    }
    public function getEmailAttribute()
    {
        return json_decode($this->shipping)->email;
    }
    public function getPhoneAttribute()
    {
        return json_decode($this->shipping)->phone;
    }
    public function getPostCodeAttribute()
    {
        return json_decode($this->shipping)->post_code;
    }
    public function getCityAttribute()
    {
        return json_decode($this->shipping)->city;
    }
    public function getAddressAttribute()
    {
        return json_decode($this->shipping)->address_line;
    }
    public function getLastNameAttribute()
    {
        return json_decode($this->shipping)?->last_name ?? json_decode($this->shipping)?->lastName;
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function orderProduct()
    {
        return $this->hasOne(OrderProduct::class, 'order_id');
    }
    public function scopeFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query
            ->when(request('sales') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('sales') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('sales') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }
    public function scopeCountFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query
            ->when(request('orders') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('orders') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('orders') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }


    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
