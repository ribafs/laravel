# Middleware no Laravel 7

O middleware fornece um mecanismo conveniente para filtrar solicitações HTTP que entram em seu aplicativo. Por exemplo, o Laravel inclui um middleware que verifica se o usuário do seu aplicativo está autenticado. Se o usuário não estiver autenticado, o middleware redirecionará o usuário para a tela de login. No entanto, se o usuário for autenticado, o middleware permitirá que a solicitação prossiga no aplicativo.

Middleware adicional pode ser escrito para executar uma variedade de tarefas além da autenticação. Um middleware CORS pode ser responsável por adicionar os cabeçalhos adequados a todas as respostas que saem de seu aplicativo. Um middleware de registro pode registrar todas as solicitações recebidas em seu aplicativo.

Existem vários middlewares incluídos no framework Laravel, incluindo middleware para autenticação e proteção CSRF. Todos esses middleware estão localizados no diretório:

app/Http/Middleware

## Para criar um novo middleware

php artisan make:middleware CheckAge

## Criará a classe CheckAge em app/Http/Middleware:
```php
<?php
namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
}
```
Before & After Middleware

Whether a middleware runs before or after a request depends on the middleware itself. For example, the following middleware would perform some task before the request is handled by the application:
```php
<?php

namespace App\Http\Middleware;

use Closure;

class BeforeMiddleware
{
    public function handle($request, Closure $next)
    {
        // Perform action

        return $next($request);
    }
}
```
However, this middleware would perform its task after the request is handled by the application:
```php
<?php

namespace App\Http\Middleware;

use Closure;

class AfterMiddleware
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // Perform action

        return $response;
    }
}
```
Registrando um middleware
```php
app/Http/Kernel.php

protected $routeMiddleware = [
...
    'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
];

```
