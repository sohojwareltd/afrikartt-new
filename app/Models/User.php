<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Traits\HasMeta;
use Carbon\Carbon;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasMeta, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $with = ['followedShops'];
    protected $meta_attributes = [
        "phone",
        'birth_date',
        'tax_no',
        'card_info',
        'nid',
        'bank_info',
        'address',
        'payment_method',
        'first_step_completed',
        'second_step_completed',
        'third_step_completed',
        'fourth_step_completed',

    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role_id',
        'l_name',
        'email_verified_at',
        'remember_token',
        'ffl'
    ];
    // protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role->name === 'admin' || $this->role->name === 'vendor' || $this->role->name === 'employee';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }
    public function shops()
    {
        return $this->hasMany(Shop::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }
    public function shopAddress()
    {
        return $this->hasOne(Address::class, 'user_id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }
    public function shop()
    {
        return $this->hasOne(Shop::class);
    }
    public function verification()
    {
        return $this->hasOne(Verification::class);
    }
    public function massages()
    {
        return $this->hasMany(Massage::class, 'reciver_id');
    }

    public function followedShops()
    {
        return $this->belongsToMany(Shop::class, 'shop_user', 'user_id', 'shop_id')->withTimestamps();
    }
    public function follows(Shop $shop)
    {
        // dd($this->followedShops()->where('shop_id', $shop->id)->get(),$shop->id,auth()->user()->id());
        // $cacheKey = 'user:' . $this->id . ':follows_shop:' . $shop->id;
        // return \Illuminate\Support\Facades\Cache::remember($cacheKey, now()->addMinutes(10), function () use ($shop) {
        return $this->followedShops()->where('shop_id', $shop->id)->exists();
        // });
    }

    public function chargeWithSubscription($amount, $comment)
    {
        return $this->invoiceFor(
            $comment,
            $amount
        );
    }

    public function getSubscription()
    {
        return $this->subscription('basic');
    }

    public function subscriptionStatus()
    {
        if ($this->getSubscription->stripe_status !== 'active' || $this->getSubscription->ends_at !== null) {
            $status = false;
        } else {
            $status = true;
        }
        return $status;
    }

    public function getCard()
    {
        return $this->defaultPaymentMethod();
    }

    public function cancelSubscription()
    {
        return $this->subscription('basic')->cancel();
    }

    public function cancelSubscriptionNow()
    {
        return $this->subscription('basic')->cancelNow();
    }


    public function resumeSubscription()
    {
        return $this->subscription('basic')->cancel();
    }


    public function notifications()
    {
        return $this->hasmany(Notification::class, 'user_id');
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class, 'user_id');
    }

    public function defaultBankAccount()
    {
        return $this->hasOne(BankAccount::class, 'user_id')->where('is_default', true);
    }

    public function isFollowingShop($shopId)
    {
        return $this->followedShops()->where('shop_id', $shopId)->exists();
    }

    public function scopeFilter($query)
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();

        return $query->whereHas('orders', function ($query) {
            $query->where('shop_id', auth()->user()->shop->id);
        })
            ->when(request('customers') == 2, function ($query) {
                $query->whereYear('created_at', '=', Carbon::now()->year);
            })
            ->when(request('customers') == 3, function ($query) {
                $query->where('created_at', Carbon::now());
            })
            ->when(request('customers') == 1, function ($query) use ($currentWeekStart, $currentWeekEnd) {
                $query->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd]);
            });
    }
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'product_user_wishlist')
            ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
