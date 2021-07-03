# Middlewares são filtros 

Intermediários entre model e controller

https://www.youtube.com/watch?v=YwHRSe9_zpI&list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY&index=55

O Middleware é um mecanismo de filtragem de requisição HTTP. Ou seja, ele permite ou barra determinados fluxos de requisição que entram na sua aplicação, baseado em regras definidas.

O Middleware de autenticação do Laravel é considerado de rota, mas, ainda existem outros 2 tipos: os Middlewares globais e os grupos de Middlewares, que falarei a seguir.

Middleware: o Laravel apresenta fácil integração com o middleware. Middleware é útil quando você deseja interagir com o processo de request e response de seu aplicativo de uma maneira que não polua a lógica específica do aplicativo.

O middleware é um código não específico do domínio que, no entanto, pode interagir com seus aplicativos, ciclo de request/response. Exemplos desse código incluem autenticação e autorização, armazenamento em cache, monitoramento de desempenho e compactação de conteúdo; enquanto todos esses recursos são cruciais, nenhum é específico do domínio e, portanto, não deve exigir que você polua o código do seu projeto para tirar proveito dele. O Laravel 5 adiciona suporte para middleware e até inclui vários recursos úteis, soluções de middleware que você pode começar a usar em seus aplicativos agora.

Um processo adequado de autenticação e autorização deve passar pela filtragem primeiro, ele filtra os usuários junto com outras credenciais. Se o exame de filtragem
passa, somente então usuários autenticados podem entrar no seu aplicativo. Laravel apresenta o conceito de middleware entre os processos de filtragem, para que a filtragem adequada ocorra antes de tudo começar. Você pode pensar no middleware como uma série de camadas que as solicitações HTTP devem passar antes que realmente atinjam seu aplicativo. O mais se um aplicativo for avançado, mais camadas poderão examinar as solicitações nos estágios diferentes e, se um teste de filtragem falhar, a solicitação será totalmente rejeitada.

Mais simplesmente, o mecanismo de middleware verifica se o usuário está autenticado. Se o usuário não estiver autenticado, o middleware enviará o usuário de volta à página de login. E se o middleware está satisfeito com a autenticação do usuário, permite que a solicitação continue mais adiante na aplicação.

Também há outras tarefas às quais o middleware foi atribuído. Por exemplo, registrar o middleware pode registrar todas as solicitações recebidas no seu aplicativo.  Desde que eu vou discutir os processos de autenticação e autorização em detalhes, você examinará a middleware responsável por essas tarefas em particular posteriormente neste capítulo.

Nesta seção, você está interessado no middleware que lida com autenticação e proteção CSRF. Todos esses componentes de middleware estão localizados em

app/Http/middleware.

## Usar o middleware auth somente em certas rotas
```php
protected $request;

public function __construct(Request $request){
  $this->request = $request;
  // $this->middleware('auth'); // Filtra todas as rotas
  //$this->middleware('auth')->only('create'); // Filtra somente a create
  $this->middleware('auth')->only(['create','store']); // Filtra somente a create
  // $this->middleware('auth')->except(['index','show']); // Filtra todas as rotas, exceto index e show
}
```
## Configurar em app/Http/Kernel.php

## Criar novo middleware
Cuja finalidade é permitir que somente certo usuário pode acessar algumas rotas

php artisan make:middleware VerificarLoginMiddleware

Cria em

app/Http/Middleware/VerificarLoginMiddleware.php
```php
Registrar no Kernel
app/Http/Kernel.php

No array $routeMiddleware[
  ...
  'verivy.login' => \App\Http\Middleware\VerificarLoginMiddleware::class,
];
```
## Adicionar para a rota desejada:

Route::produtos('/produtos', 'ProdutoController')->middleware('auth', 'verify.login');

## Ajustar o middleware criado:

app/Http/Middleware/VerificarLoginMiddleware.php

No método handle()
```php
public function handle($request, Closute $next){
  $user = auth()->user();
  if($user->email != 'ribafs@gmail.com'){
    return rediredt('/');// ou para login
  }
  return $next($request);
}

/* ou
  if(!in_array($user->email, ['']){// vários e-mails negados
    return rediredt('/');// ou para login
  }
*/
```

## Restringir ações de usuários. 

Exemplos: autenticação

artisan é similar ao bake no Cake

php artisan - lista os comandos

## Criar uma nova middleware

php artisan make:middleware MyMiddlewarePerson

Ver o arquivo em:

app/Http/Middleware

MyMiddlewarePerson.php

dd() - retorna muitas informações importantes


## Controllers
Camada principal de código
https://www.youtube.com/watch?v=5PU_eX_QWxs&list=PLVSNL1PHDWvTQnUQjhBEzY2ZSzJTR9zcZ&index=9

php artisan make:controller ProdutosController

Criou o arquivo ProdutosController.php em:

app/Http/Controllers

## Criar rota chamando um controller e seu método index

Route::get('produtos', 'ProdutosController@index');

Criar um folder produtos em views:

resources/views/painel/produtos

Criar index.blade.php em produtos contendo:

<h1>Lista de Produtos</h1>

No Controller fica assim:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProdutosController extends Controller
{
	public function index()
	{
//		return 'Listagem dos produts';
		return view('painel.produtos.index');
	}
}
```
Passar array do Controller para a view

		return view('painel.produtos.index', ['nome' => 'Carlos Ferreira']);

Na view chamar:

<h1>Lista de Produtos</h1>
Nome do Usuário: {{$nome}}

Criar método create com form

resources/view/painel/produtos/create.blade.php

Update

Destroy


## Criar uma migration

php artisan make:migration create_table_carros

Criar a tabela editando o arquivo gerado
```php
    public function up()
    {
        Schema::create('carros', function (Blueprint $table){
			$table->increments('id');
			$table->string('nome');
			$table->string('palca');			
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carros');
    }
```
php artisan migrate

Criará as tabelas no SGBD

Criar uma seeder

php artisan make:seeder CarrosSeeder

Cria em databases/seeders

Editar DatabaseSeeder.php e adicione a linha ao final da função run():

$this->call('CarrosSeeder')

Depois de criar o seeder execute:

php artisan db:seed

Cria o arquivo e popula a tabela.
```php
class DashboardController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');

    $this->middleware('admin-auth')
    ->only('admin');

    $this->middleware('team-member')
    ->except('admin');
  }
}

public function __construct()
  {
      $this->middleware('auth')->except('index', 'show');
  }

public function create()
    {
        //
        if(Auth::user()->is_admin == 1){
            return view('tasks.create');
        }
        else {
          return redirect('home');
        }
    }

public function update(Request $request, $id)
    {
        if(Auth::user()->is_admin == 1){
            $post = Task::findOrFail($id);
            $post->title = $request->input('title');
            $post->body = $request->input('body');
            $post->save();
            if($post){
             return redirect('tasks');
            }
        }
    }

    public function edit($id)
    {
      if(Auth::user()->is_admin == 1){
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
      }
      else {
        return redirect('home');
      }
    }

public function update(Request $request, $id)
    {
        //
        if(Auth::user()->is_admin == 1){
          if($file = $request->file('image')){
              $name = $file->getClientOriginalName();
              $post = Article::findOrFail($id);
              $post->title = $request->input('title');
              $post->body = $request->input('body');
              $post->published_at = $request->input('published_at');
              $post->image = $name;
              $post->save();
              $file->move('images/upload', $name);
          }
 else {
              // code...
              $post = Article::findOrFail($id);
              $post->title = $request->input('title');
              $post->body = $request->input('body');
              $post->published_at = $request->input('published_at');
              $post->save();
          }
          if($post){             
            return redirect('articles')->with('status', 'Article Updated!');
          }
        }
    }

 public function store(Request $request)
    {
        if($file = $request->file('image')){
         $name = $file->getClientOriginalName();
         $post = new Article;
         $post->title = $request->input('title');
         $post->body = $request->input('body');
         $post->published_at = $request->input('date');
         $post->image = $name;
         $post->save();
         $file->move('images/upload', $name);
   }
         if($post){      
          return redirect('articles')->with('status', 'Article Created!');
         }
    }

public function create()
    {
      if( Auth::check() ){
        if(Auth::user()->role_id == 1){
                return view('companies.create');
        }
      }
        return view('auth.login');
    }
```

## Existem dois tipos de middleware

    1. Global middleware 
    2. Route based middleware

Para registrar um middleware como global devemos registrar em

app\Http\Kernel.php

Para usar um middleware em rota
    1. Middleware on single Route 

Route::get('admin/dashboard', 'AdminController@index')->middleware('admin');

    2. Middleware on a group of Routes 
```php
Route::group(['middleware' => ['admin']], function () {
    Route::get('admin/dashboard', 'AdminController@index');
    Route::get('admin/profile', 'AdminController@profile');
});
```
https://desertebs.com/laravel/how-to-use-laravel-middleware-with-example

```php
 public function handle($request, Closure $next)
    {
      if(auth()->user()->isAdmin == 1){
        return $next($request);
      }
        return redirect('home')->with('error','You have not admin access');
    }

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function admin()
    {
        return view('admin');
    }

}
```
admin.blade.php
```php
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>ADMIN PAGE</title>
  </head>
  <body>
    WELCOME TO ADMIN ROUTE
  </body>
</html>

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin/routes', 'HomeController@admin');
});

Route::get('admin/routes', 'HomeController@admin')->middleware(['admin','auth']);
```
https://appdividend.com/2017/07/18/laravel-5-middleware-tutorial/ 

Running middleware on every request
So, let's start by running our middleware on every request. Simple add it to $middleware no Kernel.php

Running middleware on specific routes
OK, now let's move our custom middleware to the optional stack, with a key:
    protected $routeMiddleware

$this->middleware()
Or, you can use the $this->middleware() method on any controller (or its methods) if the controller extends the base controller:
```php
use Illuminate\Routing\Controller;

class AwesomeController extends Controller {

    public function __construct()
    {
        $this->middleware('csrf');
        $this->middleware('auth', ['only' => 'update'])
    }

}
```
How do I implement before vs. after filters in middleware?
```php
class BeforeMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
        // Do Stuff
        return $next($request);
    }

}

class AfterMiddleware implements Middleware {

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // Do stuff
        return $response;
    }

}
```

php artisan make:middleware RoleMiddleware

Adicionar o middleware ao Kernel e configurar
```php
App\Http\Middleware\RoleMiddleware.php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{

    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!$request->user()->hasRole($role)) {
             abort(404);

        }

        if($permission !== null && !$request->user()->can($permission)) {
              abort(404);
        }

        return $next($request);

    }
}


App\Http\Kernel.php
protected $routeMiddleware = [
    .
    .
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];


Agora nas rotas podemos fazer assim:

Route::group(['middleware' => 'role:developer'], function() {

   Route::get('/admin', function() {

      return 'Welcome Admin';
      
   });

});
```

Adicionando Middlewares para Roles e Permissões

Podemos criar roles para áreas específicas do aplicativo. Por exemplo, você pode fornecer acesso para gerenciar a seção do usuário apenas para gerentes de projeto. Para isso, usaremos o Laravel Middleware. Usando o middleware, podemos adicionar controle extra às solicitações recebidas no seu aplicativo.

Para criar um middleware para funções, execute o comando abaixo.

php artisan make:middleware RoleMiddleware

Abra o app/Http/Middleware/RoleMiddleware.php e deixe assim:
```php
<?php
namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!auth()->user()->hasRole($role)) {
            abort(404);
        }
        if($permission !== null && !auth()->user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
```
Neste middleware, estamos verificando se o usuário atual não possui a role/permissão especificada e, em seguida, retorne a página de erro 404. Existem muitas possibilidades de usar roles e permissões no middleware para controlar as solicitações recebidas, tudo depende dos requisitos do seu aplicativo.
Antes de usar este middleware, você deve adicioná-lo ao seu arquivo App\Http\Kernel.php.
```php
protected $routeMiddleware = [
...
'role'  =>  \App\Http\Middleware\RoleMiddleware::class, // our role middleware
...
```
Agora podemos usar o middleware:
```php
Route::group(['middleware' => 'role:project-manager'], function() {
   Route::get('/dashboard', function() {
      return 'Welcome Project Manager';
   });
});
```

Via Middleware

Laravel includes a middleware that can authorize actions before the incoming request even reaches your routes or controllers. By default, the Illuminate\Auth\Middleware\Authorize middleware is assigned the can key in your App\Http\Kernel class. Let's explore an example of using the can middleware to authorize that a user can update a blog post:
```php
use App\Post;

Route::put('/post/{post}', function (Post $post) {
    // The current user may update the post...
})->middleware('can:update,post');
```
In this example, we're passing the can middleware two arguments. The first is the name of the action we wish to authorize and the second is the route parameter we wish to pass to the policy method. In this case, since we are using implicit model binding, a Post model will be passed to the policy method. If the user is not authorized to perform the given action, a HTTP response with a 403 status code will be generated by the middleware.
Actions That Don't Require Models

Again, some actions like create may not require a model instance. In these situations, you may pass a class name to the middleware. The class name will be used to determine which policy to use when authorizing the action:
```php
Route::post('/post', function () {
    // The current user may create posts...
})->middleware('can:create,App\Post');
```


