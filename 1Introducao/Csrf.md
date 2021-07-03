# CSRF

https://laravel.com/docs/7.x/csrf

O Laravel facilita a proteção do seu aplicativo contra ataques de falsificação de solicitação entre sites (CSRF). As falsificações de solicitação entre sites são um tipo de exploração maliciosa em que comandos não autorizados são executados em nome de um usuário autenticado.

O Laravel gera automaticamente um "token" CSRF para cada sessão de usuário ativa gerenciada pela aplicação. Esse token é usado para verificar se o usuário autenticado é quem está realmente fazendo as solicitações ao aplicativo.

Sempre que definir um formulário HTML em seu aplicativo, você deve incluir um campo de token CSRF oculto no formulário para que o middleware de proteção CSRF possa validar a solicitação. Você pode usar a diretiva @csrf Blade para gerar o campo de token:
```php
<form method="POST" action="/profile">
    @csrf
    ...
</form>
```

## Tokens CSRF e JavaScript

Ao construir aplicativos que usem JavaScript, é conveniente que sua biblioteca HTTP JavaScript anexe automaticamente o token CSRF a cada solicitação de saída. Por padrão, a biblioteca Axios HTTP fornecida no arquivo resources/js/bootstrap.js envia automaticamente um cabeçalho X-XSRF-TOKEN usando o valor do cookie XSRF-TOKEN criptografado. Se você não estiver usando esta biblioteca, precisará configurar manualmente esse comportamento para o seu aplicativo.

Mais uma vantagem de se usar os recursos do framework, assim como suas convenções.

## Excluindo URIs da proteção CSRF

Às vezes, você pode querer excluir um conjunto de URIs da proteção CSRF. Por exemplo, se você estiver usando o Stripe para processar pagamentos e o sistema de webhook deles, será necessário excluir a rota do gerenciador de webhook Stripe da proteção CSRF, pois o Stripe não saberá qual token CSRF enviar para suas rotas.

Normalmente, você deve colocar esses tipos de rotas fora do grupo de middleware da web que o RouteServiceProvider aplica a todas as rotas no arquivo routes/web.php. No entanto, você também pode excluir as rotas adicionando seus URIs à propriedade $except do middleware VerifyCsrfToken:
```php
<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'stripe/*',
        'http://example.com/foo/bar',
        'http://example.com/foo/*',
    ];
}

```

