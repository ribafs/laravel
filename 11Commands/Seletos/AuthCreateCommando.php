<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
//use Illuminate\Support\Facades\Artisan;
use Artisan;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class AuthCreateCommando extends Command
{
    protected $signature = 'auth7:create';

    protected $description = 'Implementar autenticação no Laravel 7';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

    $str = "composer require laravel/ui --dev

php artisan ui {front} --auth

front pode ser:
- bootstrap
- vue
- react

npm install && npm run dev

npm audit fix";

$this->info(PHP_EOL);
$this->info(PHP_EOL);
$this->info(PHP_EOL);
$this->output->write('<info>Passos para implementar Auth no Laravel 7</info>');
$this->info(PHP_EOL);
$this->output->write($str);
$this->info(PHP_EOL);

    }
}
