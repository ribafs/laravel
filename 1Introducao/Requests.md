# HTTP Requests

https://laravel.com/docs/7.x/requests

## Acessando o Request

Para obter uma instância do request HTTP atual por meio de injeção de dependência, você deve type-hint a classe Illuminate\Http\Request no método do seu controller. A instância de request de entrada será injetada automaticamente pelo contãiner de serviço:
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) // Aqui
    {
        $name = $request->input('name');

        print $name;
    }
}

Route::put('user/{name}', 'UserController@index');

php artisan serve

localhost:8000/user/Ribamar
```
Dependency Injection e parâmetros em rotas

Se o seu método do controller também espera entrada de um parâmetro de rota, você deve listar seus parâmetros de rota após suas outras dependências. Por exemplo, se sua rota for definida assim:
```php
Route::put('user/{id}', 'UserController@update');
```
Você ainda pode digitar a sugestão de Illuminate\Http\Request e acessar a id do parâmetro de rota definindo o método do controlador da seguinte maneira:
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function update(Request $request, $id)
    {
        //
    }
}
```
Você também pode type-hint a classe Illuminate\Http\Request em um fechamento de rota. O contêiner de serviço injetará automaticamente a solicitação de entrada no Closure quando for executado:
```php
use Illuminate\Http\Request;

Route::get('/', function (Request $request) {
    //
});
```
Request Path & Method

A instância do Illuminate\Http\Request provê uma variedade de métodos para examinar o HTTP request para sua aplicação e extender a classe Symfony\Component\HttpFoundation\Request. Abaixo detalharemos:

Recebendo o Request Path

O método path returna as informações do request path. Portanto, se o request de entrada for direcionada a http://domain.com/foo/bar, o método path irá returnar 
foo/bar:
```php
$uri = $request->path();
```
O método is permite que você deve verificar se o caminho do request recebido corresponde a um determinado padrão. Você pode usar o caractere * como um curinga ao utilizar este método:
```php
if ($request->is('admin/*')) {
    //
}
```
Recuperando o URL de request

Para recuperar a URL completa do request recebida, você pode usar os métodos url ou fullUrl. O método url retornará o URL sem a QueryString de consulta, enquanto o método fullUrl inclui a QueryString de consulta:
```php
// Without Query String...
$url = $request->url();

// With Query String...
$url = $request->fullUrl();
```
Recebendo o método request

O método método retornará o verbo HTTP para o request. Você pode usar o método isMethod para verificar se o verbo HTTP corresponde a uma determinada string:
```php
$method = $request->method();

if ($request->isMethod('post')) {
    //
}
```
Recebendo todos os inputs de dados

Você também pode recuperar todos os dados de entrada como uma matriz usando o método all:
```php
$input = $request->all();
```
Recebendo todos os values dos inputs

Usando alguns métodos simples, você pode acessar todas as entradas do usuário de sua instância Illuminate\Http\Request sem se preocupar com qual verbo HTTP foi usado para o request. Independentemente do verbo HTTP, o método de entrada pode ser usado para recuperar a entrada do usuário:
```php
$name = $request->input('name');
```
Você pode passar um valor padrão como o segundo argumento para o método input. Este valor será retornado se o valor de entrada solicitado não estiver presente na solicitação:
```php
$name = $request->input('name', 'Sally');
```
Ao trabalhar com formulários que contêm entradas de array, use a notação de "dot" para acessar os arrays:
```php
$name = $request->input('products.0.name');

$names = $request->input('products.*.name');
```
Você pode chamar o método input sem nenhum argumento para recuperar todos os valores de entrada como uma matriz associativa:
```php
$input = $request->input();
```
Recuperando entrada de uma QueryString

Enquanto o método de entrada recupera valores de toda a carga útil do request (incluindo a QueryString), o método de consulta recupera apenas os valores da QueryString:
```php
$name = $request->query('name');
```
Se os dados do valor da query string solicitada não estiverem presentes, o segundo argumento para este método será retornado:
```php
$name = $request->query('name', 'Helen');
```
Você pode chamar o método de consulta sem nenhum argumento para recuperar todos os valores da query string de consulta como uma matriz associativa:
```php
$query = $request->query();
```

