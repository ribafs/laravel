# Laravel >= 5.5 have auto-discovery e não requer configuração manual de pacotes.

Service providers are the central place of all Laravel application bootstrapping. Your own application, as well as all of Laravel's core services are bootstrapped via service providers.

But, what do we mean by "bootstrapped"? In general, we mean registering things, including registering service container bindings, event listeners, middleware, and even routes. Service providers are the central place to configure your application.

If you open the config/app.php file included with Laravel, you will see a providers array. These are all of the service provider classes that will be loaded for your application. Note that many of these are "deferred" providers, meaning they will not be loaded on every request, but only when the services they provide are actually needed.

In this overview you will learn how to write your own service providers and register them with your Laravel application.

    Service providers can be defined as the central place to configure all the entire Laravel applications. 
    Applications, as well as Laravel's core services, are bootstrapped via service providers. 
    These are powerful tools for maintaining class dependencies and performing dependency injection.
     Service providers also instruct Laravel to bind various components into the Laravel's Service Container.

An artisan command is given here which can be used to generate a service provider:
```php
            php artisan make: provider ClientsServiceProvider  
```
Almost, all the service providers extend the Illuminate\Support\ServiceProviderclass. Most of the service providers contain below-listed functions in its file:
```php
    Register() Function
    Boot() Function
```
Within the Register() method, one should only bind things into the service container.

One should never attempt to register any event listeners, routes, or any other piece of functionality within the Register() method.

Hope it helps!!


First of all, Laravel uses service container and service providers, not server container or server provider :)

Here are some benefits of using dependencies injection (DI):

Simplify the object creation

Because your Test class constructor is quite simple, you don't see the benefit of dependencies injection. Think about a class like this:
```php
class Complex {
    public function __construct(
        FooService $fooService,
        BarService $barService,
        int $configValue
    ) {

    }
}
```
Without DI, you have to get (or create) instances of $fooService and $barService, retrieve the value of $configValue from the configuration files every time you want a new instance of the Complex class.

With DI, you tell the service container how to create the Complex instance once, then the container can give the correct instance for you with one call (e.g. $container->make(Complex::class))

Manage the couplings between your classes

Continue with the previous example. What happens if the FooService and BarService depends on other classes, too?

Without DI, you have to create instances of the dependent objects (and hope that they do not depends on other classes). This usually ends with multiple instances of one class created, a waste of codes and computer memory.

With DI, all dependent objects are created by the container (you have to register those classes with the container before). The container also manager to keep only one instance of each class if you want, which save the amount of code as well as the amount of memory used by your program.
Only use one instance of your classes when registering with singleton

To keep only one instance of the class in the whole life of the current request, you can register your class creation process with singleton method instead of bind


## Service providers for laravel

Service providers are the central place of all Laravel application bootstrapping. Your own application, as well as all of Laravel's core services are bootstrapped via service providers.

But, what do we mean by "bootstrapped"? In general, we mean registering things, including registering service container bindings, event listeners, middleware, and even routes. Service providers are the central place to configure your application.

If you open the config/app.php file included with Laravel, you will see a providers array. These are all of the service provider classes that will be loaded for your application. Of course, many of these are "deferred" providers, meaning they will not be loaded on every request, but only when the services they provide are actually needed.

Imagine you have created a class which requires multiple dependencies and in general, you use it like this:
```php
$foo = new Foo(new Bar(config('some_secret_key')), new Baz(new Moo(), new 
Boo()), new Woo('yolo', 5));
```
it's doable, but you wouldn't want to figure out these dependencies every time you try to instantiate this class. That's why you want to use a service provider wherein the register method you can define this class as:
```php
$this->app->singleton('My\Awesome\Foo', function ($app) {
   return new Foo(new Bar(config('some_secret_key')), new Baz(new Moo(), new 
   Boo()), new Woo('yolo', 5));
});
```
This way, if you need to use this class, you can just type hint it in the controller (container will figure it out) or ask for it manually like
```php
$foo = app(My\Awesome\Foo::class). Isn't that easier to use? ;)
```
below Link will guide you how to write your own service providers and register them and use with your Laravel application.

https://laravel.com/docs/5.7/providers



## Simply? A scalable require();

When your app runs, it requires additional code, often packaged as "services" (See the "app/Services" folder) to get things done.

"Service Providers" are Laravel's way of packaging and managing the code needed to load these additional "services" (or running other code) at app bootup.

They are run in 2 phases - "register", and "boot"; each one defined by a same-named method on the provider.

The list of service providers for your app is listed in config/app.php, and this is how you specify which ones will run, and in what order (you don't need to run all of the service providers in the services folder, you can just keep them there, doing nothing).

When Laravel boots, it looks at the list, loads the right Providers, which in turn have their register() and boot() methods called at the right time.

Then the rest of the app boots, and subsequent tasks which need access to any "services" loaded by the "service providers", have them.

I was frustrated at how "codey" it all seemed at the start, but now I'm used to it, it's not a bad way to do things.



## Classes that provide a service for the application: https://laravel.com/docs/5.2/providers

Basically, features are wrapped up in ‘services’ that can be added or removed from the application, by adding or removing the corresponding service provider class. So things like routing, mail, etc. are services, and their functionality added to the Laravel framework via their service providers


## Criar Provider
```php
php artisan make:provider PermissionsServiceProvider

<?php
namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        //
    }

    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::directive('role', function ($role) {
             return "if(auth()->check() && auth()->user()->hasRole({$role})) :"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
             return "endif;"; //return this endif statement inside php tag
        });

    }
}
```

## Registrar
```php
config\app.php
 'providers' => [

        App\Providers\PermissionsServiceProvider::class,
    
 ],
```

