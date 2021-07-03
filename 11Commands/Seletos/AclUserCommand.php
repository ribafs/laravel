<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use DB;

class AclUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {name} {email} {password} {slug-role} {slug-perm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add user to ACL';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function clear(){
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          system('cls');
      } else {
          system('clear');
      }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $slug_role = $this->argument('slug-role'); // array
        $slug_perm = $this->argument('slug-perm'); // array

        //$userQry = User::all()->where('name', $name)->first();

        $role = Role::where('slug',$slug_role)->first(); // Precisa ser uma das roles existentes em 'roles'
        $perm = Permission::where('slug',$slug_perm)->first(); // Precisa ser uma das permissions que existem em 'permissions'

        //if($userQry->name != $name){
            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = bcrypt($password);
            $user->save();

            $user->roles()->attach($role); // Esta role precisa existir em 'roles' para que seja adequadamente anexada
            $user->permissions()->attach($perm); // Esta role precisa existir em 'permissions' para que seja adequadamente anexada
            $this->info('Usuárioo criado com sucesso. Confira na tabela users '.PHP_EOL);
            $this->info(PHP_EOL);
/*
        }else{
            $userQry->roles()->attach($role); // Esta role precisa existir em 'roles' para que seja adequadamente anexada
            $userQry->permissions()->attach($perm); // Esta role precisa existir em 'permissions' para que seja adequadamente anexada
            $thisQry->info('Usuárioo criado com sucesso. Confira na tabela users '.PHP_EOL);
            $thisQry->info(PHP_EOL);
        }
*/
    }
}
