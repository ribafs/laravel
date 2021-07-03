<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class ControllerCreateCommand extends Command
{
    protected $signature = 'controller:create {plural} {singular} {field_search}';

    protected $description = 'Criação de um controller já com conteúdo';

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
      $fld = $this->argument('field_search');
      $singular = ucfirst($this->argument('singular'));
      $plural = $this->argument('plural');
      $path = 'app/Http/Controllers/'.$singular.'Controller.php';

      if(!file_exists($path)){
        // Sobrescrever strings

        $str=file_get_contents('app/Console/Commands/controller_modelo.php');
        $str=str_replace('cliente', $this->argument('singular'), $str);
        $str=str_replace('$clientes', $plural, $str);
        $str=str_replace('clientes', $plural, $str);
        $str=str_replace('Cliente', $singular, $str);
        $str=str_replace('Singular', $singular, $str);
        $str=str_replace('nome', $fld, $str);
        $str=str_replace('namespace App\\Console\\Commands', 'namespace App\\Http\\Controllers', $str);

        //write the entire string
        file_put_contents('controller_modelo.php', $str);

        // Rename to Vendedor.php
        rename('controller_modelo.php', 'app/Http/Controllers/'.ucfirst($singular).'Controller.php');
      }else{
        $this->output->write('Controller já existe');
        $this->info(PHP_EOL);
        exit;
      }

//      $this->clear();
      $this->info(PHP_EOL);
      $this->output->write('Controller gravado em '.$path);
      $this->info(PHP_EOL);
      $this->output->write('LEMBRE QUE ESTE CONTROLLER PREVÊ UMA ROTA DO TIPO resource, como esta abaixo:');
      $this->info(PHP_EOL);
      $this->output->write('Route::resource(\'clientes\', \'ClientesController\');');
      $this->info(PHP_EOL.' Concluído ');
    }
}
