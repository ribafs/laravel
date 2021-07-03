## Escrevendo Gates

Podemos definir Gates no AuthServiceProvider

Definir users com roles

Editar app/Providers/AuthServiceProvider.php
```php
<?php 
namespace App\Providers;
  
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
  
class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
            
    ];
  
    public function boot()
    {
        $this->registerPolicies();
   
        /* define a admin user role */
        Gate::define('isAdmin', function($user) {
           return $user->role == 'admin';
        });
       
        /* define a manager user role */
        Gate::define('isManager', function($user) {
            return $user->role == 'manager';
        });
      
        /* define a user role */
        Gate::define('isUser', function($user) {
            return $user->role == 'user';
        });
    }
}
```
ou
```php
public function boot()
{
    $this->registerPolicies();

    // Definindo permissão para role
    Gate::define('edit-settings', function ($user) {
        return $user->isAdmin;
    });

    Gate::define('update-post', function ($user, $post) {
        return $user->id === $post->user_id;
    });
}
```
ou
```php
public function boot()
{
    $this->registerPolicies();
    Gate::define('update-post', 'App\Policies\PostPolicy@update');
}
```
Use Gates

Now, we will user our custom gate in our blade file. i created three button for each roles. When user will login then user will see only user button and same way others.

So, let's update your home file as like bellow:
```php
resources/views/home.blade.php
@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
   
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
  
                    @can('isAdmin')
                        <div class="btn btn-success btn-lg">
                          You have Admin Access
                        </div>
                    @elsecan('isManager')
                        <div class="btn btn-primary btn-lg">
                          You have Manager Access
                        </div>
                    @else
                        <div class="btn btn-info btn-lg">
                          You have User Access
                        </div>
                    @endcan
  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
Mas quando temos um projeto grande idealmente devemos criar policies separadas.

Gates são closures que determinam se um usuário está autorizado a executar uma determinada ação e são normalmente definidos na classe 
App\Providers\AuthServiceProvider

usando a facade Gate. Gates sempre recebe uma instância de usuário como seu primeiro argumento e pode, opcionalmente, receber argumentos adicionais, como um modelo relevante do Eloquent:
```php
/**
 * Register any authentication / authorization services.
 *
 * @return void
 */
public function boot()
{
    $this->registerPolicies();

    Gate::define('edit-settings', function ($user) {
        return $user->isAdmin;
    });

    Gate::define('update-post', function ($user, $post) {
        return $user->id === $post->user_id;
    });
}
```
Gates também podem ser definidos usando uma string de retorno de chamada no estilo do método Class@method, como controladores:
```php
/**
 * Register any authentication / authorization services.
 *
 * @return void
 */
public function boot()
{
    $this->registerPolicies();
    Gate::define('update-post', 'App\Policies\PostPolicy@update');
}
```
## Autorizando Ações

Para autorizar uma ação usando gates, você deve usar os métodos allow ou denies. Observe que você não é obrigado a passar o usuário autenticado no momento para esses métodos. O Laravel cuidará automaticamente de passar o usuário para o gate Fechamento:
```php
if (Gate::allows('edit-settings')) {
    // The current user can edit settings
}

if (Gate::allows('update-post', $post)) {
    // The current user can update the post...
}

if (Gate::denies('update-post', $post)) {
    // The current user can't update the post...
}
```
Se você gostaria de determinar se um determinado usuário está autorizado a executar uma ação, você pode usar o método forUser na fachada do Gate:
```php
if (Gate::forUser($user)->allows('update-post', $post)) {
    // The user can update the post...
}

if (Gate::forUser($user)->denies('update-post', $post)) {
    // The user can't update the post...
}
```
Você pode autorizar várias ações ao mesmo tempo com os métodos any ou none:
```php
if (Gate::any(['update-post', 'delete-post'], $post)) {
    // The user can update or delete the post
}

if (Gate::none(['update-post', 'delete-post'], $post)) {
    // The user cannot update or delete the post
}
```
## Autorizando ou lançando exceções

Se você quiser tentar autorizar uma ação e lançar automaticamente um Illuminate\Auth\Access\AuthorizationException
se o usuário não tiver permissão para executar a ação dada, você pode usar o método Gate::authorize. Instâncias de AuthorizationException são convertidas automaticamente em uma resposta HTTP 403:
```php
Gate::authorize('update-post', $post);

// The action is authorized...
```php
## Fornecendo Contexto Adicional

Os métodos de portão para autorizar habilidades 
(allows, denies, check, any, none, authorize, can, cannot)
 e as diretivas de Blade de autorização (@can, @cannot, @canany) podem receber um array como o segundo argumento. Esses elementos da matriz são passados como parâmetros para o gate e podem ser usados para contexto adicional ao tomar decisões de autorização:
```php
Gate::define('create-post', function ($user, $category, $extraFlag) {
    return $category->group > 3 && $extraFlag === true;
});

if (Gate::check('create-post', [$category, $extraFlag])) {
    // The user can create the post...
}
```
## Gate Responses

So far, we have only examined gates that return simple boolean values. However, sometimes you may wish to return a more detailed response, including an error message. To do so, you may return a Illuminate\Auth\Access\Response from your gate:
```php
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

Gate::define('edit-settings', function ($user) {
    return $user->isAdmin
                ? Response::allow()
                : Response::deny('You must be a super administrator.');
});
```
When returning an authorization response from your gate, the Gate::allows method will still return a simple boolean value; however, you may use the Gate::inspect method to get the full authorization response returned by the gate:
```php
$response = Gate::inspect('edit-settings', $post);

if ($response->allowed()) {
    // The action is authorized...
} else {
    echo $response->message();
}
```
Of course, when using the Gate::authorize method to throw an AuthorizationException if the action is not authorized, the error message provided by the authorization response will be propagated to the HTTP response:
```php
Gate::authorize('edit-settings', $post);

// The action is authorized...
```
## Intercepting Gate Checks

Sometimes, you may wish to grant all abilities to a specific user. You may use the before method to define a callback that is run before all other authorization checks:
```php
Gate::before(function ($user, $ability) {
    if ($user->isSuperAdmin()) {
        return true;
    }
});
```
If the before callback returns a non-null result that result will be considered the result of the check.

You may use the after method to define a callback to be executed after all other authorization checks:
```php
Gate::after(function ($user, $ability, $result, $arguments) {
    if ($user->isSuperAdmin()) {
        return true;
    }
});
```
Similar to the before check, if the after callback returns a non-null result that result will be considered the result of the check.

## Gates in Controller:

You can also check in Controller file as like bellow:
```php
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function delete()
{
    if (Gate::allows('isAdmin')) {
        dd('Admin allowed');
    } else {
        dd('You are not Admin');
    }
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function delete()
{
    if (Gate::denies('isAdmin')) {
        dd('You are not admin');
    } else {
        dd('Admin allowed');
    }
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function delete()
{
    $this->authorize('isAdmin');
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function delete()
{
    $this->authorize('isUser');
}

if (Gate::allows('edit-settings')) {
    // The current user can edit settings
}

if (Gate::allows('update-post', $post)) {
    // The current user can update the post...
}

if (Gate::denies('update-post', $post)) {
    // The current user can't update the post...
}

If you would like to determine if a particular user is authorized to perform an action, you may use the forUser method on the Gate facade:
if (Gate::forUser($user)->allows('update-post', $post)) {
    // The user can update the post...
}

if (Gate::forUser($user)->denies('update-post', $post)) {
    // The user can't update the post...
}
You may authorize multiple actions at a time with the any or none methods:
if (Gate::any(['update-post', 'delete-post'], $post)) {
    // The user can update or delete the post
}

if (Gate::none(['update-post', 'delete-post'], $post)) {
    // The user cannot update or delete the post
}
```

## Authorizing Or Throwing Exceptions

If you would like to attempt to authorize an action and automatically throw an Illuminate\Auth\Access\AuthorizationException if the user is not allowed to perform the given action, you may use the Gate::authorize method. Instances of AuthorizationException are automatically converted to 403 HTTP response:
```php
Gate::authorize('update-post', $post);

// The action is authorized...
```


