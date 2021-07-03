<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AddUserCommand extends Command
{
    protected $signature = 'add:user {name} {email} {password}';

    protected $description = 'Adicionar um user para a tabela users';
 
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $this->info(PHP_EOL);
      $this->info('=== Adicionar novo user em users ==='.PHP_EOL);

      $name = $this->argument('name');
      $email = $this->argument('email');
      $password = bcrypt($this->argument('password'));

      $this->info(PHP_EOL);
      $banco = config("database.connections.mysql.database");

      $query = "INSERT INTO users (name, email, password) values ('$name', '$email', '$password');";

      DB::statement($query);
      config(["database.connections.mysql.database" => $banco]);

      $this->info('Registro criado. Confira na tabela users '.PHP_EOL);
      $this->info(PHP_EOL);
    }
}
