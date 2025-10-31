<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Menu;

class DebugMenus extends Command
{
    protected $signature = 'debug:menus';
    protected $description = 'Debug menu hierarchy for infinite loops';

    public function handle()
    {
        $this->info('🔍 Checking MenuItem Hierarchy...');
        
        try {
            $menuItems = \App\Models\MenuItem::with('children')->get();
            
            $this->info('📊 Total MenuItems: ' . $menuItems->count());
            
            foreach ($menuItems as $menuItem) {
                $this->info("MenuItem: {$menuItem->label} (ID: {$menuItem->id}) - Children: {$menuItem->children->count()}");
                
                if ($menuItem->children->count() > 0) {
                    foreach ($menuItem->children as $child) {
                        $this->info("  └─ Child: {$child->label} (ID: {$child->id}, Parent: {$child->parent_id})");
                        
                        // Check for circular reference
                        if ($child->id == $menuItem->id) {
                            $this->error("  ❌ CIRCULAR REFERENCE DETECTED: MenuItem {$menuItem->id} is its own child!");
                        }
                        
                        // Check for deep nesting
                        if ($child->children && $child->children->count() > 0) {
                            $this->warn("  ⚠️  Deep nesting detected - {$child->children->count()} grandchildren");
                        }
                    }
                }
                
                // Check if parent references itself
                if ($menuItem->parent_id && $menuItem->parent_id == $menuItem->id) {
                    $this->error("❌ SELF-REFERENCE DETECTED: MenuItem {$menuItem->id} is its own parent!");
                }
            }
            
            // Look for potential infinite loops
            $this->info('🔍 Checking for potential infinite loops...');
            
            foreach ($menuItems as $menuItem) {
                $visited = [];
                $this->checkForLoop($menuItem, $visited);
            }
            
            $this->info('✅ MenuItem hierarchy check complete!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error checking menu items: ' . $e->getMessage());
        }
    }
    
    private function checkForLoop($menuItem, &$visited, $depth = 0)
    {
        if ($depth > 10) {
            $this->error("❌ DEEP NESTING DETECTED: MenuItem {$menuItem->id} nested more than 10 levels deep!");
            return;
        }
        
        if (in_array($menuItem->id, $visited)) {
            $this->error("❌ INFINITE LOOP DETECTED: MenuItem {$menuItem->id} creates a circular reference!");
            return;
        }
        
        $visited[] = $menuItem->id;
        
        if ($menuItem->children) {
            foreach ($menuItem->children as $child) {
                $this->checkForLoop($child, $visited, $depth + 1);
            }
        }
        
        // Remove from visited when backtracking
        array_pop($visited);
    }
}
