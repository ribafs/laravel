# Efetuaur upgrade de um aplicativo para o Laravel 7

Editar o composer.json e atualizar

## Requisitos para o Laravel 7
- php7.2.5
- laravel/framework para ^7.0
- nunomaduro/collision para a versão ^4.1,
- phpunit/phpunit para ^8.5,

## Caso esteja usando os abaixo atualize-os:

facade/ignition para `^2.0
laravel/ui": "^2.0
laravelcollective/html": "^6.1",
spatie/laravel-permission: "^3.13

## A classe App\Exceptions\Handler deve aceitar a instância da interface Throwable ao invés da Exception:

use Throwable; // adicionar esta linha

public function report(Throwable $exception); // replace Exception with Throwable
public function render($request, Throwable $exception); // replace Exception with Throwable

## Após tudo isso execute:

composer update

## Referências
https://laravel.com/docs/7.x/upgrade


