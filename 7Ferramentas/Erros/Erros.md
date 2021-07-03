# Dicas sobre erros no Laravel

## Para corrigir alguns tipos de problemas

composer dump-autoload

ou

composer dump -o

## composer clearcache

php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan config:cache

## Se aparecer o erro:

Error
Call to undefined function App\Http\Controllers\array_except() 

Instalar

composer require laravel/helpers

Se precisar rode

composer dump-autoload


## Quando aparecer o erro

No application encryption key has been specified.

Execute

php artisan key:gen

Sempre que baixar um software com Laravel deve rodar este comando


## Mostrar os error no form, caso existam

Dentro da tag <form
```php
@if($errors->all())
  @foreach($errors->all() as $erro)
    <div class="alert alert-danger" role="alert">
      {{ $error }}
    </div>
  @endforeach
@endif
```

Quando receber um erro de que uma classe não existe ao tentar rodar o seed, exemplo:

Target class [Database\Seeds\PermissionsTableSeeder] does not exist.

Então executar somente a classe reclamada:

php artisan db:seed --class=PermissionsTableSeeder

Uma boa medida é antes executar o

composer dumpautoload

