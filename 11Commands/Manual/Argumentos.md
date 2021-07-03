# Argumentos de comandos

## Help sobre um comando

php artisan model:create -h

## Criar comando

php artisan make:command NomeCommand

## Descrição para um comando

protected $signature = 'model:create {table : Nome da tabela}';// Nome da tabela é a descrição

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

$signature - assinatura do comando

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

Valor default de Argumentos

protected $signature = 'alloted:shares {user} {age} {--difficulty=1} {--istest=4}';

Default de difficulty é 1
De istesté 4

Argumento opcional (use uma interrogação)

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
$this->argument();// deve retornar o array:

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

## Valor default para Argumentos
```php
protected $signature = 'alloted:shares {user} {age} {--difficulty=1} {--istest=3}';

protected $signature = 'order:check {--order=7}'

Testando

php artisan order:check --order=7
ou
php artisan order:check --order 7

$orderNumber = $this->option('order');  // 7

```
## Argumento  opcional

Para tornar um argumento opcional use uma interrogação

{field?*}

Como lidar com arrays juntamente com argumentos simples?

// Optional argument...
email:send {user?}

// Optional argument with default value...
email:send {user=foo}

## Argumento com array

email:send {user*}

## Argumento com array e opcional

email:send {user?*}

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
```php
do:thing {awesome}
```
O usuário roda
```php
php artisan do:thing fantastic
```
No código
```php
$this->argument('awesome'); // Deve retornar fantastic

jump:on {thing1} {thing2} 
```
Usuário roda
```php
php artisan jump:on rock boulder

$this->argument() deve retornar o array:
[
    'command': 'jump:on',
    'thing1': 'rock',
    'thing2': 'boulder'
]
```

## Recebendo um argumento
```php
$this->argument('nome_arg');
```

## Receber todos os argumentos
```php
$this->arguments();
```

## Recebdo um option
```php
$this->option('nome');
```
## Receber todos os options
```php
$this->options();
```
Dica: mantenha sempre os argumentos cercados de chaves {}.

## Trabalhando com arrays de argumentos:
```php
        $roles = [];
        foreach($slug_roles as $role){
            array_push($roles,Role::where('slug',$role)->get()); // Precisa ser uma das roles existentes em 'roles'
        }

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

