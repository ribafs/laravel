<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class DatabaseBackupCommand extends Command
{
    protected $signature = 'db:backup';
  
    protected $description = 'Databasen backup';
  
    public function __construct()
    {
        parent::__construct();
    }
  
    public function handle()
    {
        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".sql";
        if(!file_exists(storage_path().'/app/backup')){
          exec('mkdir '.storage_path().'/app/backup');
        }else{
          print 'Diretório existe'."\n";
        }
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
/* Opão com gzip

        $filename = "backup-" . Carbon::now()->format('Y-m-d') . ".gz";
        if(!file_exists(storage_path().'/app/backup')){
          exec('mkdir '.storage_path().'/app/backup');
        }else{
          print 'Diretório existe'."\n";
        }
        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
*/
    }
}

// Crédito - https://www.codechief.org/article/laravel-7-daily-monthly-weekly-automatic-database-backup-tutorial#gsc.tab=0
