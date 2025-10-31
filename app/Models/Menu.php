<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Cache;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('order');
    }

    /**
     * Clear menu cache when menu is updated
     */
    protected static function booted()
    {
        static::saved(function ($menu) {
            Cache::forget("menu_{$menu->name}_items");
        });

        static::deleted(function ($menu) {
            Cache::forget("menu_{$menu->name}_items");
        });
    }

    /**
     * Clear cache for this menu
     */
    public function clearCache()
    {
        Cache::forget("menu_{$this->name}_items");
    }
} 