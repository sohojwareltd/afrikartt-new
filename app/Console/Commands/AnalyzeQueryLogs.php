<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AnalyzeQueryLogs extends Command
{
    protected $signature = 'query:analyze {--limit=20 : Number of results to show}';
    
    protected $description = 'Analyze query logs to find memory killers';

    public function handle()
    {
        $limit = $this->option('limit');
        $logPath = storage_path('logs');
        
        $this->info('🔍 Analyzing Query Logs for Memory Issues...');
        
        // Find all query log files
        $queryLogFiles = File::glob($logPath . '/query-*.log');
        
        if (empty($queryLogFiles)) {
            $this->error('❌ No query log files found. Make sure QueryLoggerMiddleware is active.');
            return;
        }
        
        $this->info("📁 Found " . count($queryLogFiles) . " query log files");
        
        $memoryIssues = [];
        $highQueryCounts = [];
        $criticalRequests = [];
        
        foreach ($queryLogFiles as $logFile) {
            $this->info("📖 Reading: " . basename($logFile));
            
            $lines = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            foreach ($lines as $line) {
                if (strpos($line, 'HIGH MEMORY QUERY DETECTED') !== false) {
                    $memoryIssues[] = $this->parseLogLine($line);
                }
                
                if (strpos($line, 'HIGH QUERY COUNT') !== false) {
                    $highQueryCounts[] = $this->parseLogLine($line);
                }
                
                if (strpos($line, 'MEMORY CRITICAL REQUEST') !== false) {
                    $criticalRequests[] = $this->parseLogLine($line);
                }
            }
        }
        
        // Display results
        $this->displayMemoryIssues($memoryIssues, $limit);
        $this->displayHighQueryCounts($highQueryCounts, $limit);
        $this->displayCriticalRequests($criticalRequests, $limit);
        
        $this->info('✅ Analysis complete!');
    }
    
    private function parseLogLine($line)
    {
        // Extract JSON from log line
        $jsonStart = strpos($line, '{');
        if ($jsonStart !== false) {
            $jsonData = substr($line, $jsonStart);
            return json_decode($jsonData, true);
        }
        return null;
    }
    
    private function displayMemoryIssues($issues, $limit)
    {
        if (empty($issues)) {
            $this->info('✅ No high memory queries detected');
            return;
        }
        
        $this->error('🚨 HIGH MEMORY QUERIES DETECTED: ' . count($issues));
        $this->table(
            ['Query #', 'Memory Usage', 'Time', 'SQL'],
            array_slice(array_map(function($issue) {
                return [
                    $issue['query_number'] ?? 'N/A',
                    $issue['memory_usage'] ?? 'N/A',
                    ($issue['time'] ?? 'N/A') . 'ms',
                    substr($issue['sql'] ?? 'N/A', 0, 80) . '...'
                ];
            }, $issues), 0, $limit)
        );
    }
    
    private function displayHighQueryCounts($counts, $limit)
    {
        if (empty($counts)) {
            $this->info('✅ No high query count issues detected');
            return;
        }
        
        $this->warning('⚠️  HIGH QUERY COUNTS DETECTED: ' . count($counts));
        $this->table(
            ['Query Count', 'Memory Usage'],
            array_slice(array_map(function($count) {
                return [
                    $count['query_count'] ?? 'N/A',
                    $count['current_memory'] ?? 'N/A'
                ];
            }, $counts), 0, $limit)
        );
    }
    
    private function displayCriticalRequests($requests, $limit)
    {
        if (empty($requests)) {
            $this->info('✅ No critical memory requests detected');
            return;
        }
        
        $this->error('💀 CRITICAL MEMORY REQUESTS DETECTED: ' . count($requests));
        $this->table(
            ['URL', 'Peak Memory', 'Total Queries'],
            array_slice(array_map(function($request) {
                return [
                    substr($request['url'] ?? 'N/A', 0, 50) . '...',
                    $request['peak_memory'] ?? 'N/A',
                    $request['total_queries'] ?? 'N/A'
                ];
            }, $requests), 0, $limit)
        );
    }
}
