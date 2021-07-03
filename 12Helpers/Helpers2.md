# Criando um helper usando uma pasta com arquivos no Laravel 8

No Laravel um helper é uma função global em PHP, portanto são funções que podemos chamar de qualquer lugar do aplicativo. Muitas destas funções são usadas pelo framework, mas podemos criar nossos próprios helpers. Precisamos evitar de criar helpers para funções já existentes no Laravel e ficar repetitivo.

É uma boa ideia criar em helepr as funções que mais utilizamos em nossos aplicativos para que estejam sempre por perto. Podemos inclusive usar nossas funções em PHP, que já temos. É importante lembrar de não conflitar com o código do Laravel e inclusive priorizar o código do framework Para isso é recomendado consultar a documentação oficial - https://laravel.com/docs/8.x.

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

Adotarei a segunda alternativa, com arquivos e classes PHP por categoria.

## Criação do helper

- app/Helpers/dates.php
- app/Helpers/Files.php
- app/Helpers/strings.php
- app/Helpers/validation.php

Baixe estes arquivos da pasta Helpers, aqui:

[Helpers](Helpers)

## Estrutura dos helpers

- app/Helpers/dates.php - lógica de um helper

- app/Providers/HelpersServiceProvider.php - Service provider customizado que carrega nosso helper para a memória

- config/app.php - aqui registramos nosso provider

- routes/web.php - onde testaremos nosso helper, mas pode ser testado num controller, numa view,etc.

## Criar o HelpersServiceProvider.php em app/Providers com o comando:

php artisan make:provider HelpersServiceProvider

Atualizar o método register() do nosso provider:
```php
public function register()
{
    foreach (glob(app_path('Helpers/*.php')) as $filename)
    {
        require_once($filename);
    }
}
```

## Download

O arquivo que utilizei está nesta pasta:

[HelpersServiceProvider.php](HelpersServiceProvider.php)

## Registrar nosso provider

Editar o config/app.php

Adicionar a linha abaixo ao array providers:

        App\Providers\HelpersServiceProvider::class,

## Editar a rota para welcome

Route::get('/', function () {
    return Files::dirSize('c:/xampp/htdocs/joomla'); // '/var/www/html/joomla'
//    return view('welcome');
});

## Testando

php artisan serve

http://localhost:8000

Adaptado do original em inglês

https://code.tutsplus.com/tutorials/how-to-create-a-laravel-helper--cms-28537

