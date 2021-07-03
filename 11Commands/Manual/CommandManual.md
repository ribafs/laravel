# Dicas de codificação na criação de comandos para o Laravel

## Help sobre um comando

php artisan model:create -h

## Criar comando

php artisan make:command NomeCommand

## Estrutura básica entreque pelo Artisan ao criar um comando (sem os comentários)
```php
php artisan make:command NomeAcaoCommand

<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;

class NomeAcaoCommand extends Command
{
    protected $signature = 'command:name';
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        return 0;
    }
}
```

## Propriedades

$signature - assinatura

Descrição do argumento table na assinatura
   
protected $signature = 'model:create {table : Nome da tabela}';

Dois argumentos

protected $signature = 'example:command {firstName} {lastName}';

Array de argumentos (field)

protected $signature = 'model:create {table_plural} {table_singular} {field?*}';

$description - descrição

protected $description = 'Descrição do comando que aparecerá no help.';

Campos de uma certa tabela

$columns = \Illuminate\Support\Facades\DB::select("DESC {$table}");

Argumentos opcionais

protected $signature = 'alloted:shares {user} {age} {--difficulty=} {--istest=}';

{user} {--difficulty=} {--istest=} são argumentos opcionais

Para tornar um argumento opcional use uma interrogação

{field?}

## Options

Os options, como os argumentos, são outra forma de entrada do usuário. São prefixados por dois hífens (--) quando são especificados na linha de comando
```php
protected $signature = 'command:name
    {argument}
    {optionalArgument?}
    {argumentWithDefault=default}
    {--booleanOption}
    {--optionWithValue=}
    {--optionWithValueAndDefault=default}
';
```
Exemplo de uso

do:thing {awesome}

O usuário roda

php artisan do:thing fantastic

No código

$this->argument('awesome'); // Deve retornar fantastic

jump:on {thing1} {thing2} 

Usuário roda

php artisan jump:on rock boulder
```php
$this->argument() deve retornar o array:

[
    'command': 'jump:on',
    'thing1': 'rock',
    'thing2': 'boulder'
]
```

Recebendo um argumento

$this->argument('nome_arg');

Receber todos os argumentos

$this->arguments();

Recebdo um option

$this->option('nome');

Receber todos os options

$this->options();

Dica: mantenha sempre os argumentos cercados de chaves {}.

Métodos customizados auxiliares
```php
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
```
Usando no handle():

$this->clear();

Trabalhando com arrays de argumentos:
```php
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
```
Escrevendo mensagem no handle:
   
   $this->writeFile('Frase desejada aqui');

Adicionando uma quebra de linha

      $this->info(PHP_EOL);

Exemplo de comando: ModelCreate

Sobrescrevendo strings de arquivo e renomeando o mesmo:
```php
      $singular = ucfirst($this->argument('table_singular'));
      $plural = $this->argument('table_plural');
      $path = 'app/Http/Controllers/'.$singular.'Controller.php';

      if(!file_exists($path)){
        $str=file_get_contents('app/Console/Commands/modelo.php');
        $str=str_replace('clientes', $plural, $str);
        $str=str_replace('cliente', $singular, $str);
        $str=str_replace('Cliente', ucfirst($singular), $str);
        $str=str_replace('singular', $singular, $str);
        $str=str_replace('nome', $fld, $str);
        $str=str_replace('namespace App\\Console\\Commands', 'namespace App\\Http\\Controllers', $str);

        //write the entire string
        file_put_contents('modelo.php', $str);

        // Rename to Vendedor.php
        rename('modelo.php', 'app/Http/Controllers/'.ucfirst($singular).'Controller.php');
      }else{
        $this->output->write('Controller já existe');
        $this->info(PHP_EOL);
        exit;
      }
```
Mensagens
```php
   $this->line("Some text");//Uma única linha
    $this->info("Hey, watch this !");
    $this->comment("Just a comment passing by");
    $this->question("Why did you do that?"); // Fica em fundo azul claro
    $this->error("Ops, that should not happen.");

public function inlineInfo($string)
{
    $this->output->write("<info>$string</info>"); // <info> fica com fontes verdes
}

$this->output->write('my inline message', true);
$this->output->write('my inline message continues', false);// Com false puxa a próxima linha para o final desta
```

Perguntas/Questions

Pára a execução e faz uma pergunta
```php
    $answer = $this->ask('What is your name?');

    // Ask for sensitive information
    $password = $this->secret('What is the password?');

    // Choices
    $name = $this->choice('What is your name?', ['Taylor', 'Dayle'], $default);

    // Confirmation

    if ($this->confirm('Is '.$name.' correct, do you wish to continue? [y|N]')) {
        //
    }
```
Exemplo
```php
    $questions = [
        'easy' => [
            'How old are you ?', "What is the name of your mother?",
            'Do you have 3 parents ?','Do you like Javascript?',
            'Do you know what is a JS promise?'
        ],
        'hard' => [
            'Why the sky is blue?', "Can a kangaroo jump higher than a house?",
            'Do you think i am a bad father?','why the dinosaurs disappeared?',
            "why don't whales have gills?"
        ]
    ];

    $questionsToAsk = $questions[$difficulty];
    $answers = [];

    foreach($questionsToAsk as $question){
        $answer = $this->ask($question);
        array_push($answers,$answer);
    }

    $this->info("Thanks for do the quiz in the console, your answers : ");

    for($i = 0;$i <= (count($questionsToAsk) -1 );$i++){
        $this->line(($i + 1).') '. $answers[$i]);
    }
```
Usar
```php
use Illuminate\Support\Facades\Artisan;

Artisan::call('some:command');
    Artisan::call('list');
    \Artisan::call('config:clear');
    \Artisan::call('migrate');
    dd(Artisan::output());

ou
dd('Done')
```
Executando o comando criado:
```php
php artisan command:name argumento1 argumento2 --optionn1
```
Namespace Artisan

use Illuminate\Support\Facades\Artisan;

Executando comandos do sistema operacional linux

exec('comando');

exec('nohup php artisan some:command > /dev/null &');

How to run an artisan command from a controller

Apart from within another command, I am not really sure I can think of a good reason to do this. But if you really want to call a Laravel command from a controller (or model, etc.) then you can use Artisan::call()
```php
    Artisan::call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
```
One interesting feature that I wasn't aware of until I just Googled this to get the right syntax is Artisan::queue(), which will process the command in the background (by your queue workers):
```php
    Route::get('/foo', function () {
        Artisan::queue('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
     
        //
    });
```
If you are calling a command from within another command you don't have to use the Artisan::call method - you can just do something like this:
```php
    public function handle()
    {
        $this->call('email:send', [
            'user' => 1, '--queue' => 'default'
        ]);
     
        //
    }
```
Executar scripts com composer.json
```php
    "scripts": {
        "post-root-package-install": [
            "php -r \"copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "php artisan key:generate"
        ],
        "post-install-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postInstall",
            "php artisan optimize"
        ],
        "post-update-cmd": [
            "Illuminate\\Foundation\\ComposerScripts::postUpdate",
            "php artisan optimize"
        ]
    },

    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi"
        ],
        "post-root-package-install": [
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
        ],
        "post-create-project-cmd": [
            "@php artisan key:generate --ansi"
        ]
    }
```
