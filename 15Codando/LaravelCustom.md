# Trabalhar com código customizado no Laravel/Lumen

## Principais elementos do MVC no Laravel:

Exemplo: tabela produtos

Model - app/Produto.php

- Controller respectivo - app/Http/Controllers/ProdutoController.php
- View - resources/views/produtos: layout.php, index.php, edit.php, show.php, add.php, destroy.php
- Rotas - routes/web.php

Existem recomendações de que não criemos actions/métodos customizados, mas somente os do Laravel
Mas se existir uma situação em que precisamos fazer isso, acho que tá bom

1 - Aforma mais simples, criar um router que dá o recado
```php
Route::get('/', function() {
return 'Como vai?';
});
```
Chamar

http://localhost:8000

## Criar um método num model e chamar no respectivo controller

## Adicionar ao Model

app/Produto.php
```php
...
    public function custom(){
      $ret = 'Riba';
      return $ret;
    }
```

## Adicionar ao controller
app/Http/Controllers/ProdutoController.php
```php
...
    public function custom2(){
        $prod = new Produto();
        $teste = $prod->custom();
        return $teste;
    }
```
## Adicionar para o router

routers/web.php

  $router->get('authors/tt', ['uses' => 'AuthorController@custom2']);

## Router - view

Criando uma view no Laravel:

Criar o teste.blade.php em resources/views contendo:
```php
<h1>View de teste</h1>

<p>Apenas um teste</p>

---
Criar o router em routes/web.php

Route::get('/viewteste', function()
{
  return view('teste');
});
```
## Chame pela URL

php artisan serve

http://localhost:8000/viewteste

## Router e Controller

## Criar rota

Route::get('testec', 'TesteController@index');

## Se chamarmos agora

http://localhost:8000/testec

Veremos que ele tenta chamar o TesteController

## Criar o controller app/Http/Controllers/TesteController.php
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function index(Request $request){
      print 'Apenas um teste';
    }
}
```

## Chame assim

http://localhost:8000/testec

Router - Controller - View

## Criar rota

Route::get('teste2', 'Teste2Controller@index');

## Criar o controller app/Http/Controllers/Teste2Controller.php
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class Teste2Controller extends Controller
{
    public function index(Request $request){
      return view('teste');
    }
}
```
Usar a view teste.blade.php criada acima

## Chame assim

http://localhost:8000/teste2


