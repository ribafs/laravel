<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TinkerExampleCommand extends Command
{
    protected $signature = 'tinker:example';

    protected $description = 'Exemplo de uso do tinker para adicionar um registro ao model User';
 
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

    public function handle()
    {
      $this->clear();
      $this->info(PHP_EOL);
      $this->info('=== EXEMPLO DE USO DO TINKER ==='.PHP_EOL);
      $this->output->write('O tinker é muito útil para realizar testes, inserir poucos registros de forma rápida e outros');
      $this->info(PHP_EOL);
      $this->output->write('Como inserir um registro em users usando o comando -tinker- via terminal. '."\n".'Repita os comandos abaixo:');
      $this->info(PHP_EOL);
      $this->output->write("php artisan tinker

use User;
\$user = User::all();
\$user->name = 'Ribamar FS';
\$user->email = 'ribafs@gmail.com';
\$user->password = bcrypt(123456);
\$user->save();
");
      $this->info(PHP_EOL);
      $this->info('Alternativa, em apenas duas linhas: '.PHP_EOL);
      $this->output->write("use App\User;
User::create(['name'=>'Ribamar FS', 'email'=>'ribafs@gmail.com', 'password' => bcrypt(123456)]);");
      $this->info(PHP_EOL);
    }
}
