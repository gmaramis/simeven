<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExportDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:export {--file=database_backup.sql}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export database for deployment';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->option('file');
        
        $this->info("🗄️ Exporting database to: {$filename}");
        
        try {
            // Get database configuration
            $database = config('database.connections.mysql.database');
            $host = config('database.connections.mysql.host');
            $port = config('database.connections.mysql.port');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            
            $this->info("📊 Database: {$database}");
            $this->info("🌐 Host: {$host}:{$port}");
            
            // Build mysqldump command
            $command = "mysqldump -h {$host} -P {$port} -u {$username}";
            
            if ($password) {
                $command .= " -p{$password}";
            }
            
            $command .= " {$database} > {$filename}";
            
            // Execute command
            $this->info("📤 Executing: mysqldump...");
            exec($command, $output, $returnCode);
            
            if ($returnCode === 0) {
                $this->info("✅ Database exported successfully!");
                $this->info("📁 File: {$filename}");
                
                if (file_exists($filename)) {
                    $size = filesize($filename);
                    $this->info("📊 File size: " . $this->formatBytes($size));
                }
                
                $this->info("");
                $this->info("📋 Next steps:");
                $this->info("1. Upload {$filename} to Hostinger via phpMyAdmin");
                $this->info("2. Create subdomain: event.kairosmanado.id");
                $this->info("3. Push changes to GitHub to trigger deployment");
                
            } else {
                $this->error("❌ Database export failed!");
                $this->error("💡 Make sure mysqldump is installed and database credentials are correct");
                $this->error("💡 Alternative: Use phpMyAdmin to export database manually");
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Error: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
