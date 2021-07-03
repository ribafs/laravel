# Criação de um Helper simples no Laravel 8

No Laravel um helper é uma função global em PHP, portanto são funções que podemos chamar de qualquer lugar do aplicativo. Muitas destas funções são usadas pelo framework, mas podemos criar nossos próprios helpers. Precisamos evitar de criar helpers para funções já existentes no Laravel e ficar repetitivo ou gerar conflito.

## Documentação oficial

https://laravel.com/docs/8.x/helpers#introduction

## Temos basicamente três alternativas para deixar nosso helper global:

- Adicionar ao composer.json no autoload
- Podemos registrar ele no AppServiceProvider
- Ou podemos criar um service provider customizado que carregue nosso helper juntamente com dependências. Registrar e criar um alias.

A última alternativa me parece a mais adequada para um artesão de código, por ser mais manutenível.

## Quanto a onde criar

Isso também tem várias alternativas:

- Podemos criar um arquivo em app/helpers.php, contendo somente funções de helpers, para o c aso de ter poucas funções
- Podemos criar uma pasta app/Helpers, contendo classes com os helpers, ou então somente arquivos com funções por categoria
- Ou uma pasta em app/Http/Helpers, como sugerem alguns

Adotarei a primeira, mas caso o arquivo helpers.php cresça, adotarei a segunda com classes separando por categoria.

## Criação do helper

app/helpers.php
```php
<?php

  function dateDMY($date){
      return \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $date)->toDateTimeString();
  }
  
  function random_code(){
 
    return rand(1111, 9999);
  }
```
## Estrutura do nosso helper

- app/helpers.php - lógica do nosso helper

- app/Providers/HelpersServiceProvider.php - Service provider customizado que carrega nosso helper para a memória

- config/app.php - aqui registramos nosso provider

- routes/web.php - onde testaremos nosso helper, mas pode ser testado num controller, numa view,etc.

## Criar o HelpersServiceProvider.php em app/Providers com o comando:

php artisan make:provider HelpersServiceProvider

Atualizar o método register() do nosso provider:
```php
public function register()
{
    require_once app_path('helpers.php');
}
```

## Registrar nosso provider

Editar config/app.php

Adicionar a linha abaixo ao array providers:

        App\Providers\HelpersServiceProvider::class,

## Editar a rota para welcome

Route::get('/', function () {
    return random_code();
    return view('welcome');
});

## Testando

php artisan serve

http://localhost:8000

## Veja um exemplo usando a pasta app/Helpers, com alguns arquivos PHP dentro

[Helpers2](Helpers2.md)

Adaptado do original em inglês

https://code.tutsplus.com/tutorials/how-to-create-a-laravel-helper--cms-28537

