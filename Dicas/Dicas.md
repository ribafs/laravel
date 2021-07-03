# Algumas dicas

## Quando temos um arquivo contendo apenas uma função
No caso não podemos adicionar ao namespace

Então adicionamos ao composer.json

Numa entrada
```php
{
    "autoload": {
        "files": [
          "src/MyLibrary/functions.php"
        ]
    }
}
```
composer dumpautoload

Agora as funções dentro de functions.php são visíveis em todo o projeto.


## Ordenar os registros do index por nome:

$contatos = Contato::all()->orderBy('nome');


## Alterar o nome da aplicação:

No arquivo .env
APP_NAME="Nome da aplicação"


## put e delete requerem uma informação extra do laravel

edit

@method('PUT')

no show e no index

@method('DELETE')


## Confirmação da exclusão na view index

<button type="submit" class="btn btn-danger btn-sm" title="Delete Cliente" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>


## O uso da função compact() do php no laraveldo está em desuso

        return view('clientes.index', compact('clientes'));

Em seu lugar usar o array na forma []

        return view('clientes.index', ['clientes' => $clientes]);



