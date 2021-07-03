# Laravel 7.x Middleware Tutorial With Example

https://www.codechief.org/article/laravel-6-middleware-tutorial-with-example

Como criar um middleware customizado e como usar ele em um controller.

No laravel 7 temos um middleware auth cuidando da segurança de acesso de usuários.

Middleware é uma forma de verificar HTTP request antes que sejam passados para o controller.

## Todos os middlewares em Laravel ficam na pasta

app/Http/Middleware

## Criando um middleware (semelhante no laravel 5, 6 e 7)
```php
php artisan make:middleware TestMiddleware
```
Criado aqui

app/Http/Middleware/TestMiddleware.php
```php
<?php
namespace App\Http\Middleware;

use Closure;

class TestMiddleware
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
        $arr = [
            'Bangladesh',
            'America',
            'Canada',
            'Brasil'
        ];

        if(in_array($request->country,$arr)){
            dd("{$request->country} is available in this array");
        }

        return $next($request);
    }
}
```
## Criar rota
```php
Route::get('/test', 'HomeController@test');
```
## Criar controller
```php
php artisan make:controller HomeController
```
### Adicionar método ao controller

app/Http/Controllers/HomeController.php
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\TestMiddleware;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(TestMiddleware::class); //Our Middleware
    }

    public function test()
    {
        return "done";
    }
}
```
Olha, registramos nosso middleware dentro do nosso controlador. Agora, essa lógica de middleware funcionará para este URL de rota. Portanto, agora se você visitar o url abaixo, verá a imagem abaixo.
```php
127.0.0.1:8000/test?country=Bangladesh
```
Bangladesh is available in this array.

Veja o exemplo acima, ainda podemos usar middleware dentro de nosso controlador para chamar nossa classe de middleware personalizada dentro de nosso método __contruct no HomeController. Agora queremos chamá-lo usando um nome como "tom or ben ten". Para isso temos que registrar nosso middleware dentro do arquivo Kernel.php. então abra-o e cole o código a seguir.
```php
app/Http/Kernel.php

    protected $routeMiddleware = [        
        'tom' => \App\Http\Middleware\OlaMiddleware::class,
```
Dê uma olhada, agora Tom é o nome do nosso Middleware. agora podemos usá-lo como abaixo.
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Middleware\TestMiddleware;

class HomeController extends Controller
{
   // public function __construct()
   // {
   //     $this->middleware(TestMiddleware::class); 
  //  }
   
    public function __construct()
    {
        $this->middleware('tom'); //Now we can call it like that
    }
   
}
```
Além disso, você pode definir o middleware diretamente nas rotas também. Basta adicionar a rota diretamente!
```php
Route::get('/test', 'HomeController@test')->middleware('tom');
```

How to Create Configure and Use Laravel Custom middleware in Laravel 5.8

https://www.itechempires.com/2019/08/how-to-create-configure-and-use-custom-middleware-in-laravel-5-8/amp/

Criar, configurar e aplicar um middleware customizado no laravel, o que deve ajudar a proteger ou filtrar http requests ou routes.

Middleware em laravel se posicionam entre o aplicativo e as HTTP requests.

laravel new middleware --auth

cd middleware

Na pasta app/Http/Middleware podemos ver alguns middlewares que já vem com o laravel, cada um com uma finalidade diferente.

## Registro

Todos os middlewares que criamos devemos registrar no

app/Http/Kernel.php

## Todos os middlewares nativos estão registrados no Kernel.php

Ao ler este tutorial, suponho que você já esteja trabalhando com um aplicativo laravel existente e deseja criar seu próprio middleware personalizado para filtrar o http solicitado/request de acordo com suas necessidades.

Então, aqui neste exemplo, vou dar a você a etapa de adição de middleware de rota; para dar um exemplo, basicamente criaremos um middleware personalizado para admin, portanto, o trabalho de nosso middleware será verificar se o usuário autenticado atual é administrador ou não.

Portanto, com base na função de autenticado, protegeremos nossas rotas de aplicativos.

vamos começar:

## Criar um middleware
```php
php artisan make:middleware VerifyIfAdmin
```
Criará app/Http/Middleware/VerifyIfAdmin.php
```php
<?php
namespace App\Http\Middleware;

use Closure;

class VerifyIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
```
## Configurar a ação do middleware

Em seguida, temos que configurar o middleware para definir a ação. Ação significa basicamente uma lógica ou uma regra de validação para filtrar o request http.

Neste caso, nossa regra de validação é verificar se o usuário ativo atual é administrador ou usuário normal.

Vamos implementar a lógica para validar a mesma regra, use o seguinte script:
```php
<?php
namespace App\Http\Middleware;

use Closure;

class VerifyIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */    public function handle($request, Closure $next)
    {
        if (!$request->user()->admin) {
            if ($request->wantsJson()) {
                return response()->json(['Message', 'You do not have access to this module.'], 403);
            }
            abort(403, 'You do not have access to this module.');
        }
        return $next($request);
    }
}
```
Se você perceber que no script acima na função handle() estou usando o objeto $request e do objeto request estou processando a função user() para o usuário autenticado atual e, dependendo do sinalizador de administrador, estou usando a instrução condicional se o usuário não é administrador, aborta a solicitação e mostra o código de status de permissão negada 403.

Nota: Em seu aplicativo, você pode ter uma tabela separada ou um nome de arquivo diferente para a função do usuário, portanto, certifique-se de ajustar o nome do arquivo de acordo.

Então, aqui está como nosso middleware vai ser executado:
     • Verifica se o usuário é administrador
     • se sim, prossegue com o pedido
     • se não, verifica se a solicitação precisa de uma resposta json
     • se sim, retorna a resposta json com o código de status 403
     • se não, retorna a resposta normal com o código de status 403

## Registrar middleware personalizado:

Como sabemos para executar ou usar qualquer middleware no aplicativo laravel terá que se registrar no arquivo Kernel.php localizado dentro de app/Http/Kernel.php)

Então edite o arquivo /app/Http/Kernel.php em seu editor de código e registre este middleware dentro da seção $routeMiddleware conforme mostrado abaixo:
```php
protected $routeMiddleware = [
'verify.admin' => \App\Http\Middleware\VerifyIfAdmin::class,
```
Por que entrar no middleware de rota, porque o middleware que vamos usar é apenas para definir rotas específicas que vamos proteger? Este não é um middleware global porque o middleware global deve ser executado em cada request que chega ao aplicativo.

Então, agora nosso middleware está pronto para uso na próxima, vamos ver como podemos usar o middleware com rotas laravel

## Aplicar middleware de rota personalizada

Então, basicamente, o objetivo é adicionar restrições às rotas específicas onde apenas o usuário administrador deve ter acesso a elas.

Para demonstrar, vou adicionar algumas rotas de exemplo aqui, pois estou trabalhando em um aplicativo totalmente novo, no seu caso, você pode estar trabalhando em seu projeto existente, então não se preocupe em adicionar essas rotas de exemplo, você pode adicionar este middleware diretamente em seu rotas existentes.

Vou criar uma rota Admin com um Controlador Admin associado a ela.

Criar um controller em Admin
```php
php artisan make:controller Admin/AdminController
```
Atualizar
```php
<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(['Hello World!'], 200);
    }
}
```
Adicionar uma rota ao routes/web.php
```php
Route::get('admin/test', 'Admin\AdminController@index')->middleware(['auth', 'verify.admin']);
```
Como você pode ver na rota acima, aplicamos dois middlewares e fornecemos nomes de middleware ao array.

Então, o que vai acontecer aqui primeiro para acessar essa rota, o usuário precisa ser autenticado e, em seguida, o próximo usuário deve ter uma função de administrador.

Aplicando middleware ao grupo de rotas:
Aqui está o exemplo de como você pode proteger várias rotas usando o grupo de rotas:
```php
Route::group(['middleware' => ['auth', 'verify.admin']], function(){
    Route::get('admin/test', 'Admin\AdminController@index');
    Route::get('admin/test2', 'Admin\AdminController@test2');
    Route::get('admin/test3', 'Admin\AdminController@test3');
    Route::get('admin/test4', 'Admin\AdminController@test4');
});
```
Forma alternativa de proteção de rota usando middleware:

Há também uma maneira alternativa ou eu diria que a melhor maneira de proteger o request http é aplicar o middleware ao lado do nosso método de construtor de controlador.

Aplicando middleware usando o método do construtor:
```php
app/Http/Controllers/Admin/AdminController.php:

<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verify.admin']);
    }

    public function index()
    {
        return response()->json(['Hello World!'], 200);
    }
}
```
Portanto, observe que adicionei um construtor a esta classe AdminController e simplesmente chamei uma função de middleware da mesma forma que fiz com a rota no arquivo web.php.

Usando a maneira acima, seu controlador estará totalmente protegido com o middleware, então todos os próximos métodos que você vai adicionar dentro deste AdminController também ficarão protegidos.

Excluindo a função do controlador do middleware:
Às vezes, você pode querer excluir uma função específica da proteção de middleware, então, nesse caso, você só precisa passar e excluir o método junto com o nome do método da classe

Veja como você pode excluir uma função da proteção de middleware:
```php
<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verify.admin'])->except('testFunc');
    }

    public function index()
    {
        return response()->json(['Hello World!'], 200);
    }

    public function testFunc()
    {
        return response()->json(['Public data'], 200);
    }
}
```
Se você deseja excluir várias funções, basta passar array como um argumento para o método except:

Por exemplo:
```php
$this->middleware(['auth', 'verify.admin'])->except(['testFunc', 'secondfunction2']);
```
É sempre bom usar proteção de nível de controlador para suas solicitações/requests http, pois fornece uma solução para excluir uma solicitação específica, mas sim, é a regra que você sempre pode usar da maneira que quiser.

## Teste o middleware personalizado:

Agora vamos ver o que fizemos

Gerar scaffolding de autenticação padrão do Laravel:

Para este exemplo, vou gerar um scaffold de autenticação padrão no laravel para a demonstração, é claro que você não precisa fazer isso se estiver trabalhando em seu projeto existente, mas sim, se você estiver me acompanhando com o novo projeto, você pode gerar, não há mal nenhum em fazer isso:

Implementar a autenticação (feito na instalação)

Adicione um sinalizador de administrador personalizado à tabela users:

Adicionar um novo campo admin dentro da migration da tabela users antes de migrar para que tenha o campo de sinalizador de administrador em nossa tabela.
```php
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
```
## Config

.env

php artisan migrate

## Usar o tinker para adicionar dois usuários, um admin e outro não
```php
php artisan tinker
User::create(['name'=>'Admin', 'email'=>'admin@gmail.com', 'password' => bcrypt(123456), 'admin' => true])
User::create(['name'=>'Autor', 'email'=>'autor@gmail.com', 'password' => bcrypt(123456), 'admin' => false   ])
```

## Testar
```php
php artisan serve
localhost:8000/admin/test
```
### Testar com os dois usuários

Não há limite para a criação de middleware, você pode criar quantos quiser até atingir seu objetivo de requisito de aplicativo.

Controle de acesso com middleware no laravel 7

Destinado a projetos simples

Criar um CRUD com o gerador de crudes, clientes

Implementar o middleware nele, sendo
```php
super - acesso a todas as views
admin - acesso apenas a index, show
user - acesso somente a index
```
Todos têm acesso a index, mas com exceção dos botões New, Edit e Delete

Edit por admin e super

Create somente por super

## Roles
```php
1)User:
2)Admin:
3)Superadmin:
```
## Instalação limpa do laravel 7

laravel new middlew

cd middlew

## Permissões
```php
1)is_permission = 0: User Role
2)is_permission = 1: Admin Role
3)is_permission = 2: Superadmin Role
```
Editar a migration users e adicionar o campo
```php
$table->tinyInteger('is_permission');
```

## Configurar o banco

.env

Apague todas as tabelas do banco, caso existam
```php
php artisan migrate
```
## Implementar autenticação
```php
composer require laravel/ui --dev
php artisan ui bootstrap --auth
npm install && npm run dev
```
## Criar um helper com as roles
```php
app/Http/helpers.php

<?php
  function checkPermission($permissions){
    $userAccess = getMyPermission(auth()->user()->is_permission);
    foreach ($permissions as $key => $value) {
      if($value == $userAccess){
        return true;
      }
    }
    return false;
  }
  function getMyPermission($id)
  {
    switch ($id) {
      case 1:
        return 'admin';
        break;
      case 2:
        return 'super';
        break;
      default:
        return 'user';
        break;
    }
  }
```
Editar a seção autoload do composer.json e deixar assim:
```php
    "autoload": {
        "classmap": [
                "database/seeds",
                "database/factories"
        ],
        "psr-4": {
            "App\\": "app/"
        },
        "files": [
            "app/Http/helpers.php"
        ]
    },
```
composer dumpautoload

## Criar um middleware
```php
php artisan make:middleware CheckPermission
```
## Editar o middleware
```php
app/Http/Middleware/CheckPermission.php

<?php
namespace App\Http\Middleware;

use Closure;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $permission = explode('|', $permission);
        
        if(checkPermission($permission)){
            return $next($request);
        }
        return response()->view('errors.check-permission');
    }
}
```
Editar

app/Http/Kernel.php

Adicionar na 
```php
protected $routeMiddleware
        'check-permission' => \App\Http\Middleware\CheckPermission::class,
```

Editar

routes/web.php

E adicionar
```php
Route::group(['middleware'=>'auth'], function () {
        Route::get('public',['middleware'=>'check-permission:user|admin|super','uses'=>'HomeController@public']);
        Route::get('admin',['middleware'=>'check-permission:admin|super','uses'=>'HomeController@admin']);
        Route::get('super',['middleware'=>'check-permission:super','uses'=>'HomeController@super']);
  });
```

public - vê somente o destinado a si

admin - vê o do public e o seu

super - vê o de todos

## Adicionar HomeController
```php
app/Http/Controllers/HomeController.php

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function public()
    {
        return view('public');// Criar view all_users - is_permission = 0 (usuário comun)
    }

    public function admin()
    {
        return view('admin');
    }

    public function super()
    {
        return view('super');
    }
}
```
## Adicionar a view home e outras
```php
resources/views/home.blade.php

@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Permission</div>
                <div class="panel-body">
                    @if(checkPermission(['user','admin','super']))
                    <a href="{{ url('public') }}"><button>Access All Users</button></a>
                    @endif
                    @if(checkPermission(['admin','super']))
                    <a href="{{ url('admin') }}"><button>Access Admin and Superadmin</button></a>
                    @endif
                    @if(checkPermission(['super']))
                    <a href="{{ url('super') }}"><button>Access Only Superadmin</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

resources/views/errors/check-permission.blade.php
```php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/app.css" rel="stylesheet">
    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
<div class="container text-center">
        <h1>You don't have permission for access this page <br/> Please contact you Superadmin!</h1>
</div>
</body>
</html>
```
## Criar as views public, admin e super

public.blade.php
```php
@extends('layouts.app')
<!-- Esta view é vista por qualquer usuário-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Permission</div>
                <div class="panel-body">
                    @if(checkPermission(['user','admin','super']))
                    <a href="{{ url('public') }}"><button>Access All Users</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
admin.blade.php
```php
@extends('layouts.app')
<!-- Esta view é vista somente pelo user admin e pelo super-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Permission</div>
                <div class="panel-body">
                    @if(checkPermission(['admin','super']))
                    <a href="{{ url('admin') }}"><button>Access Admin and Superadmin</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```
super.blade.php
```php
@extends('layouts.app')
<!-- Esta view é vistaa somente pelo user super-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Manage Permission</div>
                <div class="panel-body">
                    @if(checkPermission(['super']))
                    <a href="{{ url('super') }}"><button>Access Only Superadmin</button></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
```

## Criar um arquivo de seed
```php
php artisan make:seeder UsersTableSeeder
```

### Editar e adicionar dentro do método run, sobrescrevendo o comentário //
```php
        DB::table('users')->insert([
          'name' => 'Super Admin',
          'email' => 'super@gmail.com',
        	'password' => bcrypt('12345678'),
          'is_permission' => 2,
        ],
        [  'name' => 'Admin User',
          'email' => 'admin@gmail.com',
        	'password' => bcrypt('12345678'),
          'is_permission' => 1,
        ],
        [  'name' => 'User Comun',
          'email' => 'user@gmail.com',
        	'password' => bcrypt('12345678'),
          'is_permission' => 0
        ]);
```
## Editar o DatabaseSeeder.php e mudar para
```php
        $this->call(UsersTableSeeder::class);
```
## Executar
```php
composer dumpautoload
php artisan db:seed --class=UsersTableSeeder
```
Ou importar este script
```php
INSERT INTO `users` (`id`, `name`, `email`, `is_permission`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1,	'Super Admin',	'super@gmail.com',	2,	NULL,	'$2y$10$922PQbnC7KJq.EFLtOD3Yu1iZeI5hTPcD8i.kiWmv4LDVfdH04uui',	NULL,	NULL,	NULL),
(2,	'Admin User',	'admin@gmail.com',	1,	NULL,	'$2y$10$FmNrHdGzKIE1.HJCj0bbZOo.bS2mCXw0BG1dceskJNKnAAfdZbk5m',	NULL,	NULL,	NULL),
(3,	'User Comun',	'user@gmail.com',	0,	NULL,	'$2y$10$fYqFgqYtM8KkcqDzRnV1fen0VBIRloAMhUfUx9dsetbcPQfJS7Bb2',	NULL,	NULL,	NULL);
```
```php
php artisan serve

http://localhost:8000/login
```

## Testar com

email - super@gmail.com

senha - 12345678

E depois com os outros dois cadastrados: admin e user

Crédito

https://www.itsolutionstuff.com/post/laravel-5-simple-user-access-control-using-middlewareexample.html


## Laravel 7/6 Custom Middleware Example

https://www.itsolutionstuff.com/post/laravel-6-custom-middleware-exampleexample.html

## Como criar e usar um middleware customizado

Middleware são usados para filtrar requisições HTTP em seu aplicativo da web. Um dos requisitos básicos de qualquer aplicação web é o filtro de requisições HTTP, então temos que fazer isso, por exemplo, make auth middleware. O middleware de autenticação sempre verifica se você está indo e, em seguida, pode acessar essas páginas. No aplicativo laravel 7, eles fornecem vários middleware da Web padrão, mas neste tutorial vamos criar um middleware personalizado para o aplicativo laravel 7.

Neste exemplo, vou criar o middleware "checkType" e vou usar simplesmente na rota, quando a rota vai rodar você deve passar o parâmetro "type" com o valor "2" e então você pode acessar essas requisições como como link de exemplo abaixo:

http://localhost:8000/check-md?type=2

Como no link acima, se você vai passar 2, então você é válido para este middleware, mas se você passar outro valor ou se esqueceu de passar, então ele dá o erro json do middleware customizado. Então, vamos seguir a etapa abaixo para criar validação customizada no aplicativo laravel 6.

Etapa 1: Criar validação personalizada
Na primeira etapa, temos que criar validação customizada usando o comando laravel 7. Então, vamos abrir seu terminal e executar o comando abaixo:

php artisan make:middleware CheckType

Atualizar app/Http/Middleware/CheckType.php
```php
<?php
namespace App\Http\Middleware;
use Closure;
class CheckType
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
        if ($request->type != 2) {
            return response()->json('Please enter valid type');
        }
        return $next($request);
    }
}
```
## Registrar em app/Http/Kernel.php
```php
protected $routeMiddleware = [
        ....
        'checkType' => \App\Http\Middleware\CheckType::class,
```
## Adicionar a rota
```php
Route::get("check-md", "HomeController@checkMD")->middleware("checkType");
```

## Criar o controller
```php
php artisan make:controller HomeController
```
### Adicionar este método
```php
    public function checkMD()
    {
        dd('You are in Controller Method');
    }
```
## Testando
```php
php artisan serve

http://localhost:8000/check-md?type=2

http://localhost:8000/check-md?type=1
```

