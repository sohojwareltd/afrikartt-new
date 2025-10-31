<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RealTimeMemoryMonitor
{
    private $memorySnapshots = [];
    
    public function handle(Request $request, Closure $next)
    {
        if (!str_contains($request->path(), 'admin') && !str_contains($request->path(), 'vendor')) {
            return $next($request);
        }
        
        // Initial memory snapshot
        $this->takeSnapshot('REQUEST_START', $request->fullUrl());
        
        // Monitor during request
        register_tick_function([$this, 'tickFunction']);
        declare(ticks=1000); // Check every 1000 operations
        
        try {
            $response = $next($request);
            $this->takeSnapshot('REQUEST_END', $request->fullUrl());
            
        } catch (\Throwable $e) {
            $this->takeSnapshot('ERROR_OCCURRED', $request->fullUrl(), [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            
            // Log all snapshots when error occurs
            $this->logAllSnapshots();
            throw $e;
        }
        
        unregister_tick_function([$this, 'tickFunction']);
        
        return $response;
    }
    
    public function tickFunction()
    {
        $currentMemory = memory_get_usage(true);
        
        // Log if memory jumps significantly
        if (!empty($this->memorySnapshots)) {
            $lastSnapshot = end($this->memorySnapshots);
            $memoryIncrease = $currentMemory - $lastSnapshot['memory'];
            
            // If memory increased by more than 50MB in one tick
            if ($memoryIncrease > 50 * 1024 * 1024) {
                $this->takeSnapshot('MEMORY_SPIKE', 'tick_function', [
                    'memory_increase' => $this->formatBytes($memoryIncrease),
                    'backtrace' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5)
                ]);
            }
        }
    }
    
    private function takeSnapshot($event, $context, $extra = [])
    {
        $snapshot = [
            'timestamp' => microtime(true),
            'event' => $event,
            'context' => $context,
            'memory' => memory_get_usage(true),
            'memory_formatted' => $this->formatBytes(memory_get_usage(true)),
            'peak_memory' => memory_get_peak_usage(true),
            'peak_memory_formatted' => $this->formatBytes(memory_get_peak_usage(true))
        ];
        
        if (!empty($extra)) {
            $snapshot = array_merge($snapshot, $extra);
        }
        
        $this->memorySnapshots[] = $snapshot;
        
        // Log critical memory levels immediately
        if (memory_get_usage(true) > 1024 * 1024 * 1024) { // 1GB
            Log::channel('query')->critical('CRITICAL MEMORY LEVEL', $snapshot);
        }
    }
    
    private function logAllSnapshots()
    {
        Log::channel('query')->error('MEMORY SNAPSHOTS DURING REQUEST', [
            'snapshots' => $this->memorySnapshots,
            'total_snapshots' => count($this->memorySnapshots)
        ]);
    }
    
    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }
}
