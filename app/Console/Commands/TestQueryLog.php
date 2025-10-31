<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestQueryLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:query-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the query logging system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing Query Log System...');
        
        try {
            \Illuminate\Support\Facades\Log::channel('query')->info('TEST LOG ENTRY', [
                'message' => 'Query logging system is working!',
                'timestamp' => now()->toISOString(),
                'memory_usage' => memory_get_usage(true)
            ]);
            
            $this->info('✅ Query log test successful!');
            $this->info('📁 Check storage/logs/query-' . date('Y-m-d') . '.log');
            
        } catch (\Exception $e) {
            $this->error('❌ Query log test failed: ' . $e->getMessage());
        }
    }
}
