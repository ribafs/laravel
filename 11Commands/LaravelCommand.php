<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;

class LaravelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comandos';// Executar com: php artisan comandos

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Executar diversos comandos em aplicativos Laravel: instalação, autenticação, backup, etc';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function auth8(){
        $this->output->write('Aguarde a implementação da autenticação no Laravel 8 na pasta atual...');
        $this->info(PHP_EOL);
        exec('composer require laravel/jetstream');
        $this->info(PHP_EOL);
        $front = $this->ask("Digite sua escolha: livewire/inertia");
        exec('php artisan jetstream:install '.$front);
        exec('npm install && npm run dev');
        exec('npm audit fix');
        $this->info(PHP_EOL);
        $this->output->write('Autenticação com '.$front.' implementada no Laravel 8');
        $this->info(PHP_EOL);
    }

    private function clearCache(){
        system('php artisan view:clear');
        system('php artisan cache:clear');
        system('php artisan route:clear');
        system('php artisan route:cache');
        system('php artisan config:cache');
        system('php artisan optimize');
        system('composer du');
    }

    private function backupBd(){
        system('php artisan config:clear');
        $this->output->write('O backup será f eito na pasta storage/app/backup');
        $this->info(PHP_EOL);        
        $filename = "backup-" . Carbon::now()->format('Y-m-d_H-i') . ".sql";
        if(!file_exists(storage_path().'/app/backup')){
          exec('mkdir '.storage_path().'/app/backup');
        }else{
          //print 'Diretório existe'."\n";
        }

        $command = "mysqldump --user=" . env('DB_USERNAME') ." --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . " > " . storage_path() . "/app/backup/" . $filename;
  
        $returnVar = NULL;
        $output  = NULL;
  
        exec($command, $output, $returnVar);
        $this->info(PHP_EOL);        
        $this->output->write('Backup concluído na pasta storage/app/backup');
    }

    private function install(){
        $name = $this->choice(
            'Qual versão do laravel deseja instalar?'."\n",
            ['laravel 8', 'laravel 7', 'laravel 6', 'laravel 5.8', 'Sair'],
            $defaultIndex = 0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        if($name == 'laravel 8') {
            $pasta = $this->ask("Instalar o laravel 8 em que pasta");
            system("laravel new $pasta");
        }elseif($name == 'laravel 7'){
            $pasta = $this->ask("Instalar o laravel 7  em que pasta");
            system("composer create-project --prefer-dist laravel/laravel:^7.0 $pasta");
        }elseif($name == 'laravel 6'){
            $pasta = $this->ask("Instalar o laravel 6  em que pasta");
            system("composer create-project --prefer-dist laravel/laravel:^6.0 $pasta");
        }elseif($name == 'laravel 5.8'){
            $pasta = $this->ask("Instalar o laravel 5.8  em que pasta");
            system("composer create-project --prefer-dist laravel/laravel:^5.8 $pasta");
        }elseif($name == 'Sair'){
            exit;
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->choice(
            'Que comandos deseja executar?'."\n",
            ['Instalar laravel', 'Autenticação no Laravel 8', 'Limpar o Cache', 'Backup BD atual', 'Sair'],
            $defaultIndex = 0,
            $maxAttempts = null,
            $allowMultipleSelections = false
        );

        if($name == 'Instalar laravel') {
            $this->install();
        }elseif($name == 'Autenticação no Laravel 8') {
            $pasta = $this->ask("Tecle enter para iniciar a autenticação no Laravel 8 ou Ctrl+C para sair");
            $this->auth8();
        }elseif($name == 'Limpar o Cache') {
            $pasta = $this->ask("Tecle enter para iniciar a limpeza do cache ou Ctrl+C para sair");
            $this->clearCache();
        }elseif($name == 'Backup BD atual') {
            $pasta = $this->ask("Tecle enter para iniciar o backup ou Ctrl+C para sair");
            $this->backupBd();
        }elseif($name == 'Sair'){
            exit;
        }

    }
}
