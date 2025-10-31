<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Menu;

class ClearMenuCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'menu:clear-cache {menu? : Specific menu name to clear cache for}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear menu cache for all menus or a specific menu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $menuName = $this->argument('menu');

        if ($menuName) {
            // Clear cache for specific menu
            $cacheKey = "menu_{$menuName}_items";
            Cache::forget($cacheKey);
            $this->info("Cache cleared for menu: {$menuName}");
        } else {
            // Clear cache for all menus
            $menus = Menu::all();
            $clearedCount = 0;

            foreach ($menus as $menu) {
                $cacheKey = "menu_{$menu->name}_items";
                Cache::forget($cacheKey);
                $clearedCount++;
            }

            $this->info("Cache cleared for {$clearedCount} menus");
        }

        return Command::SUCCESS;
    }
} 