# Debug no laravel 8

Podemos remover o ignition e instalar outro pacote de tratamento de erros

composer remove facade/ignition

"facade/ignition": "^2.3.6",

composer require filp/whoops


O Iginition tem a opção de vc compartilhar o erro gerando uma URL que vc pode enviar para um amigo.

luckily, since filp/whoops is still in your composer.json (or at least it was in mine) all you have to do is run composer remove facade/ignition and whoops will take over again.

if not, reinstall filp/whoops with composer require filp/whoops --dev, and remove ignition and that should be it.
```php
   public function render($request, Exception $e)
    {
        // Verificamos si el debug esta activo
        if (config('app.debug')) {
            // Creamos una nueva instancia de la clase Run
            $whoops = new \Whoops\Run;
            // Registramos el manejador "pretty handler"
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
 
            // Retornamos una nueva respuesta
            return response()->make(
                $whoops->handleException($e),
                method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500,
                method_exists($e, 'getHeaders') ? $e->getHeaders() : []
            );
        }
        // Si debug == false : retornamos la respuesta para la excepción
        return parent::convertExceptionToResponse($e);
    }
```
Testando

Gere algum erro e chame pelo navegador

php artisan make:middleware CheckAge


This command will place a new CheckAge class within your app/Http/Middleware directory. In this middleware, we will only allow access to the route if the supplied age is greater than 200. Otherwise, we will redirect the users back to the home URI:
```php
<?php

namespace App\Http\Middleware;

use Closure;

class CheckAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->age <= 200) {
            return redirect('home');
        }

        return $next($request);
    }
}
```
As you can see, if the given age is less than or equal to 200, the middleware will return an HTTP redirect to the client; otherwise, the request will be passed further into the application. To pass the request deeper into the application (allowing the middleware to "pass"), call the $next callback with the $request.

It's best to envision middleware as a series of "layers" HTTP requests must pass through before they hit your application. Each layer can examine the request and even reject it entirely.


