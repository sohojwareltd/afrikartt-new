<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DisableAllNavigationBadges extends Command
{
    protected $signature = 'debug:disable-badges';
    protected $description = 'Temporarily disable all Filament navigation badges to isolate memory issue';

    public function handle()
    {
        $this->info('🔧 Disabling all Filament navigation badges...');
        
        $resources = [
            'app/Filament/Resources/ProductResource.php',
            'app/Filament/Vendor/Resources/ProductResource.php', 
            'app/Filament/Resources/TicketResource.php',
            'app/Filament/Resources/UserResource.php',
            'app/Filament/Resources/ShopResource.php',
            'app/Filament/Resources/OrderResource.php',
            'app/Filament/Vendor/Resources/OrderResource.php',
            'app/Filament/Vendor/Resources/OfferRequestResource.php',
        ];
        
        foreach ($resources as $resource) {
            $path = base_path($resource);
            if (file_exists($path)) {
                $content = file_get_contents($path);
                
                // Comment out getNavigationBadge methods
                $content = preg_replace(
                    '/public static function getNavigationBadge.*?^\s*}/ms',
                    '// TEMPORARILY DISABLED FOR DEBUG
    // public static function getNavigationBadge(): ?string
    // {
    //     return null;
    // }',
                    $content
                );
                
                file_put_contents($path, $content);
                $this->info("✅ Disabled navigation badge in: $resource");
            }
        }
        
        $this->info('🎯 All navigation badges disabled. Try creating a ticket now.');
        $this->info('💡 If error persists, the issue is not in navigation badges.');
        $this->info('🔄 Run php artisan debug:restore-badges to restore them.');
    }
}
