# Controllers no Laravel 7

https://laravel.com/docs/7.x/controllers

Os controllers representam o C do MVC e são a camada de mediação entre model e view.

Em vez de definir toda a lógica de tratamento de sua solicitação como Closures em arquivos de rota, você pode desejar organizar esse comportamento usando classes de controller. Os controllers podem agrupar a lógica de tratamento de solicitações relacionadas em uma única classe. Os controllers são armazenados:
app/Http/Controllers

## Definindo um controller básico

Abaixo está um exemplo de classe de controller básico. Observe que o controller estende a classe base controller incluída no Laravel. A classe base fornece alguns métodos de conveniência, como o método de middleware, que pode ser usado para anexar o middleware às ações do controller:
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function show($id)
    {
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
```
Definindo uma rota para este controller
```php
Route::get('user/{id}', 'UserController@show');
```
Criando o esqueleto de um controller com o artisan

Controller simples, apenas a classe, o namespace e o use
```php
php artisan make:controller PrimeiroController
```
Criando um controller já com as definições de todos os actions básicos de um CRUD:
```php
php artisan make:controller SegundooController --resource
```
Podemos usar com vários controllers, passando em um array
```php
Route::resources([
    'photos' => 'PhotoController',
    'posts' => 'PostController',
]);
```

É mais conveniente especificar os middlweares no construtor da classe.
```php
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('log')->only('index');
        $this->middleware('subscribed')->except('store');
    }
```
Correspondente ao controller criado com --resource temos a rota:
```php
Route::resource('photos', 'PhotoController');
```
Esta rota aende a todos os actions do controller acima.

Podemos criar um controller com resource e já também um model

php artisan make:controller PhotoController --resource --model=Photo

Métodos de formulário de Spoofing

Como os formulários HTML não podem fazer solicitações PUT, PATCH ou DELETE, você precisará adicionar um campo _method oculto para falsificar esses verbos HTTP. A diretiva @method do Blade pode criar este campo para você:
```php
<form action="/foo/bar" method="POST">
    @method('PUT')
</form>
```
## Rotas resource parciais

Ao declarar uma rota tipo resource, você pode especificar um subconjunto de ações que o controlador deve controlar em vez do conjunto completo de ações padrão:
```php
Route::resource('photos', 'PhotoController')->only([
    'index', 'show'
]);

Route::resource('photos', 'PhotoController')->except([
    'create', 'store', 'update', 'destroy'
]);

Rotas resources para API

Route::apiResource('photos', 'PhotoController');

Route::apiResources([
    'photos' => 'PhotoController',
    'posts' => 'PostController',
]);
```
Para criar uma API coom o artisan, use:
```php
php artisan make:controller API/PhotoController --api

Route::resource('photos.comments', 'PhotoCommentController');
/photos/{photo}/comments/{comment}

Route::resource('photos', 'PhotoController')->names([
    'create' => 'photos.build'
]);

Route::resource('users', 'AdminUserController')->parameters([
    'users' => 'admin_user'
]);
/users/{admin_user}

```

