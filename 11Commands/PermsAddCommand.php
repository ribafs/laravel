<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PermsAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'perms:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adicionar permissão para um novo CRUD';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Qual o nome da permission a ser adicionada?');
        $guard_name = 'web';                             
        
        $perms = DB::select("select * from permissions where name LIKE '$name%'");  
        
        if($perms){
	        $this->info('Permissão já existe.');      
	    }else{
			DB::table('permissions')->insert(['name' => $name . '-list', 'guard_name' => $guard_name, 'created_at' => now(), 'updated_at' => now()]);
			DB::table('permissions')->insert(['name' => $name . '-index', 'guard_name' => $guard_name, 'created_at' => now(), 'updated_at' => now()]);
			DB::table('permissions')->insert(['name' => $name . '-edit', 'guard_name' => $guard_name, 'created_at' => now(), 'updated_at' => now()]);
			DB::table('permissions')->insert(['name' => $name . '-show', 'guard_name' => $guard_name, 'created_at' => now(), 'updated_at' => now()]);                        
		    $this->info('Permissão cadastrada com sucesso.');
        }
    }
}
