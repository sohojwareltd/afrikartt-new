<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id', 'label', 'url', 'target', 'icon_class', 'color', 'parent_id', 'route', 'parameters', 'order',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Clear menu cache when menu item is updated
     */
    protected static function booted()
    {
        static::saved(function ($menuItem) {
            if ($menuItem->menu) {
                Cache::forget("menu_{$menuItem->menu->name}_items");
            }
        });

        static::deleted(function ($menuItem) {
            if ($menuItem->menu) {
                Cache::forget("menu_{$menuItem->menu->name}_items");
            }
        });
    }

    /**
     * Clear cache for this menu item's menu
     */
    public function clearMenuCache()
    {
        if ($this->menu) {
            Cache::forget("menu_{$this->menu->name}_items");
        }
    }
} 