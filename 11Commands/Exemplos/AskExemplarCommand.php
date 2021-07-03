<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AskExemplarCommand extends Command
{
    protected $signature = 'asks';

    protected $description = 'Testes com ask e cia';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
    // ask
    $name = $this->ask('What is your name?');
    $this->info("Hello, $name");

    // secret - na entrada oculta mas na saída mostra
    $password = $this->secret('What is your password?');
    $this->info("This is really secure. Your password is $password");

    // confirm
    if ($this->confirm('Do you want a present?')) {
        $this->info("I'll never give you up.");
    }

    // antecipae - Pergunta e com valores default
    $name = $this->anticipate(
        'What is your name?',
        ['Jim', 'Conchita']
    );

    $this->info("Your name is $name");

    // choice
    $source = $this->choice(
        'Which source would you like to use?',
        ['master', 'develop']
    );

    $this->info("Source chosen is $source");

    // table
   $headers = ['Name', 'Awesomeness Level'];

    $data = [
        [
            'name' => 'Jim',
            'awesomeness_level' => 'Meh',
        ],
        [
            'name' => 'Conchita',
            'awesomeness_level' => 'Fabulous',
        ],
    ];

    /* Note: the following would work as well:
    $data = [
        ['Jim', 'Meh'],
        ['Conchita', 'Fabulous']
    ];
    */

    $this->table($headers, $data);

    // outro
    $headers = ['Name', 'Email'];

    // Configurar anes o banco
    $users = \App\User::all(['name', 'email'])->toArray();
    if(count($users) > 0){
      $this->table($headers, $users);
    }else{
      $this->info(PHP_EOL);
      $this->output->write('Nenhum user encontrado');
      $this->info(PHP_EOL);
      $this->info(PHP_EOL);
    }

    // progressBar
    $this->output->progressStart(10);

    for ($i = 0; $i < 10; $i++) {
        sleep(1);

        $this->output->progressAdvance();
    }
    $this->output->progressFinish();
    // Crédito - https://mattstauffer.com/blog/advanced-input-output-with-artisan-commands-tables-and-progress-bars-in-laravel-5.1/

    }
}
