# Criação de um bem pequeno aplicativo de exemplo

## Importante criar usando o artisan

Pois ele já cria com o namespace correto, o use e a definição da classe com o extends.

Criar um aplicativo somente com rota e controller

## 0) Apenas a rota
```php
Route::get('inicio', function(){
  return 'Iniciando com Laravel';
});
```
## 1) Criar um controller
php artisan make:controller PrimeiroController

## Rota

Route::get('primeiro', 'PrimeiroController@index');

## Controller
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimeiroController extends Controller
{

public function index(){
  return 'Meu primeiro controller';
}
```

## 2) Criar um controller recebendo parâmetro
php artisan make:controller PrimeiroController

## Rota

Route::get('primeiro/{nome}', 'PrimeiroController@index');

## Controller
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrimeiroController extends Controller
{

public function index($nome){
  return 'Meu primeiro controller '.$nome;
}
```
## 3) Criar um controller
php artisan make:controller MedicoController

Ele fará isso:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicoController extends Controller
{
    //
}
```
## Criar o método index()
```php
public function index(){
  // Simulando um banco de dados
  $medicos = [
    'João',
    'Antônio',
    'Pedro'
  ];

  return $medicos;
}
```
## Criar a rota

Route::get('medicos', ['uses' => 'MedicoController@index']);

## Chamar pelo navegeador

php artisan serve

http://localhost:8000/medicos

## 4) rota
Route::get('usuario/{login}/{senha}', 'UsuarioController@login');

## Controller
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuarioController extends Controller
{

  public function login($login, $senha){
    $login_view = 'Bem-vindo '.$login;
    $senha_view = bcrypt($senha);
    return view('login_view', ['login'=>$login_view], 'senha'=>$senha);
  }
}
```
## View
resources/views/login_view.php
```php
<?php

echo "<p>Login: $login</p>";
echo "<p>Senha criptografada: $senha</p>";
```
## Chamar pelo navegador

php artisan serve

http:localhost:8000/usuario/ribafs/123456

## 5) resource

php artisan make:controller VendedorController --resource

Com isso ele cria o controller juntamente com todos os actions criados para um CRUD

Uma única rota que atente a todo o CRUD

Route::resource('vendedores', 'VendedorController');

php artisan route:list
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {
      return 'Estou na view';
    }

    public function create()
    {
      return 'Estou na create';
    }

    public function store(Request $request)
    {
      return 'Estou na store';
    }

    public function show($id)
    {
      return 'Estou na show, com id '.$id;
    }

    public function edit($id)
    {
      return 'Estou na edit, com id '.$id;
    }

    public function update(Request $request, $id)
    {
      return 'Estou na update, com id '.$id;
    }

    public function destroy($id)
    {
      return 'Estou na destroy, com id '.$id;
    }
}
```
vendedores_view.php
```php
<?php
$id = 10;

echo '<a href="'.route('usuarios.index').'">Index<a><br>';
echo '<a href="'.route('usuarios.create').'">Create<a><br>';
echo '<a href="'.route('usuarios.show',$id).'">Show<a>';
?>
```
Mostrar links de cada action na view

php artisan route:list

```php
|        | GET|HEAD  | vendedores                  | vendedores.index   | App\Http\Controllers\VendedorController@index    | web        |
|        | POST      | vendedores                  | vendedores.store   | App\Http\Controllers\VendedorController@store    | web        |
|        | GET|HEAD  | vendedores/create           | vendedores.create  | App\Http\Controllers\VendedorController@create   | web        |
|        | GET|HEAD  | vendedores/{vendedore}      | vendedores.show    | App\Http\Controllers\VendedorController@show     | web        |
|        | PUT|PATCH | vendedores/{vendedore}      | vendedores.update  | App\Http\Controllers\VendedorController@update   | web        |
|        | DELETE    | vendedores/{vendedore}      | vendedores.destroy | App\Http\Controllers\VendedorController@destroy  | web        |
|        | GET|HEAD  | vendedores/{vendedore}/edit | vendedores.edit    | App\Http\Controllers\VendedorController@edit     | web     
```
- GET - index, create/form, show/form, edit/form
- POST - store
- PUT - update
- DELETE - destroy


