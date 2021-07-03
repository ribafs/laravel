# Ao instalar pacote e receber uma mensagem que não existe no pacote

Exemplo de pacote

ribafs/laravel8-acl

composer remove ribafs/laravel8-acl

Remover bootstrap/cache/config.php

Remover a entrada de

bootstrap/cache/packages.php

No meu caso
```php
  'ribafs/laravel8-acl' => 
  array (
    'providers' => 
    array (
      0 => 'Ribafs\\Laravel8Acl\\Laravel8ServiceProvider',
    ),
  ),
```
Remover a entrada do array providers em

config/app.php

## Alternativa

Remover com o composer

composer remove ribafs/laravel-acl

composer update

## Remover manualmente o pacote em

vendor/ribafs/laravel8-acl

## Limpar todo o cache do laravel

composer du

## Limpar o cache do composer
```php
composer clearcache

php artisan config:clear
php artisan cache:clear

php artisan route:list
```
Um último recurso seria instalar em outro aplicativo, cujo cache está limpo
```php
composer update
composer install -v

composer config disable-tls false
```
Verificar e remover entradas do
composer.json


