# Criar diretivas customizadas no Blade

## Editar o

app/Providers/AppServiceProvider.php

## No método
```php
    public function boot()
    {
        Blade::directive('directive_name', function () {
            return 'My First Blade Directive';
        });
    }
```
## Testando numa view
```php
    <body>
        @directive_name()
```

Vamos criar as diretivas isHome, notHome e endHome, para fazer algo assim numa view
```php
@isHome
    <p>We are on the homepage</p>
@notHome
    <p>We are on a different page than the homepage</p>
@endHome
```
Editar o

app/Providers/AppServiceProvider.php

E no método
```php
    public function boot()
    {
        Blade::directive('isHome', function () {
            $isHomePage = false;

            // check if we are on the homepage
            if ( request()->is('/') ) {
                $isHomePage = true;
            }

            return "<?php if ($isHomePage) { ?>";
        });

        Blade::directive('notHome', function () {
            return "<?php } else { ?>";
        });

        Blade::directive('endHome', function () {
            return "<?php } ?>";
        });
    }
```
## Criar as rotas
```php
Route::get('/', function(){
    return view('welcome');
});

Route::get('/posts', function(){
    return view('welcome');
});
```
## Na view welcome
```php
        @isHome
            <p>We are on the homepage</p>
        @notHome
            <p>We are on a different page than the homepage</p>
        @endHome
```
## Testar
```php
php artisan view:clear
php artisan serve

localhost:8000

localhost:8000/posts
```

## Diretiva 'if'
```php
    public function boot()
    {
        Blade::if('isHome', function () {
            return request()->is('/');
        });
    }

        @isHome
            we are on home
        @else
            not home
        @endisHome
```
## Passando argumentos
```php
    public function boot()
    {
        Blade::directive('greet', function ($name) {
            return "<?php echo 'Hello ' . $name ?>";
        });
    }

    <body>
        @greet('Tony')
    </body>

    public function boot()
    {
        Blade::if('env', function ($environment) {
            return app()->environment($environment);
        });
    }

   <body>
        @env('local')
            <p>The application is in the local environment</p>
        @elseenv('testing')
            <p>The application is in the testing environment</p>
        @else
            <p>The application is not in the local or testing environment</p>
        @endenv
    </body>
```
## Criando um novo provider
```php
php artisan make:provider BladeServiceProvider
```
## Registrar no config/app.php, array providers
```php
'providers' => [

    // Other Service Providers
    App\Providers\BladeServiceProvider::class,
    
],
```
https://devdojo.com/tnylea/custom-laravel-blade-directive

