<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AuthCreateCommand extends Command
{
    protected $signature = 'auth:create {front : bootstrap, vue ou react}';

    protected $description = 'Implementar autenticação no Laravel 7';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->output->write('Aguarde a implementação ...');
        $this->info(PHP_EOL);
        exec('composer require laravel/ui --dev');
        $front = $this->argument('front');
        exec('php artisan ui '.$front.' --auth');
        exec('npm install && npm run dev');
        exec('npm audit fix');
        $this->info(PHP_EOL);
        $this->output->write('Auth implementado no Laravel 7');
        $this->info(PHP_EOL);
    }
}
