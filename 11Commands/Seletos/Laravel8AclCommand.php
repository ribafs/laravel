<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Laravel8AclCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:laravel8';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        File::copyDirectory(storage_path('/acl/migrations/'), base_path('database/migrations/'));        
        File::copyDirectory(storage_path('/acl/seeders/'), base_path('database/seeders/'));        
        File::copyDirectory(storage_path('/acl/Models/'), app_path('Models/'));      
        File::copy(storage_path('/acl/PermissionsServiceProvider.php'), app_path('Providers/PermissionsServiceProvider.php'));        
        File::copy(storage_path('/acl/RoleMiddleware.php'), app_path('Http/Middleware/RoleMiddleware.php'));        
        File::copy(storage_path('/acl/web.php'), base_path('routes/web.php'));    
    }
}
