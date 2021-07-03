<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModelCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model:create {table_plural} {table_singular} {field?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criação de um Model já com conteúdo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function writeFile($file, $content){
        $fp = fopen($file, "w");
        fwrite($fp, $content); // grava a string no arquivo. Se não existir será criado
        fclose($fp);
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

      $c = count($this->argument('field'));
      $fld='';
      for($x=0; $x<$c;$x++)
      {
        if($x < $c-1){
        $fld .= "'".$this->argument('field')[$x]."',";
        }else{
        $fld .= "'".$this->argument('field')[$x]."'";
        }
      }

      $classe=ucfirst($this->argument('table_singular'));
    $model = "<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class $classe extends Model
{
    protected \$table = '".$this->argument('table_plural')."';
    protected \$fillable = [$fld];    
}";
//      $this->clear();
      $this->writeFile('app/'.$classe.'.php', $model);
      $this->info(PHP_EOL);
      $this->output->write('Model gravado em '.'app/'.$classe.'.php');
      $this->info(' Concluído ' . PHP_EOL);
    }
}
