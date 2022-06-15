<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PermsDelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'perms:del';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remover uma permissão';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Qual o nome da permission a ser removida?');
                
		$perms = DB::delete("delete from permissions where name = '$name'");  
        
        if($perms){
		    $this->info('Permissão removida com sucesso.');
        }
    
        return 0;
    }
}
