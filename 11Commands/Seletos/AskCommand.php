<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AskCommand extends Command
{
    protected $signature = 'ask:teste';

    protected $description = 'Teste sobre o método ask';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
      $nome = $this->ask('Qual o seu nome?');

      if ($this->confirm('Deseja continuar?')) {
        $idade = $this->ask('Qual sua idade?');

        $this->line("Seu nome é ".$nome);

        $this->line("Sua idade é ".$idade);

        $this->line("Grato e até logo");

      }else{
        $this->line("Grato e até logo");
      }
    }
}
