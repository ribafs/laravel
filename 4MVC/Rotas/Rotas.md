# Usando Rotas no Laravel 7

Rotas são a parte do aplicativo que o programador prepara para responder a certas URLs que o usuário poderá solicitar ou então a links.
O caso mais usual de rotas e recomendado, simplificando, o aplicativo recebe uma solicitação de url, as rotas previamente preparadas recebem o pedido/requisição/request e o passam para um controller. O controller interage com o model, o model vai ao banco de dados, então o model devolve as devidas informações ao controller.O controller pode efetuar algumas operações, como verificação de autenticação, validação, etc. Então o controller passa o resultado final para a respectiva view. A view devolve ao usuário que as solicitou.

As rotas fazem o mapeamento entre as urls e os recursos do aplicativo.

Mas existe uma grande variedade de usos das rotas.

Nós veremos a seguir diversos exemplos de uso de rotas.

Na versão 7 do laravel as rotas ficam em:

routes/web.php

Existem outros tipos de rotas mas aqui lidaremos apenas com as web.

## Editar a rota default e deixar assim:
```php
Route::get('/', function () {
    return '<h1>Seja bem vindo ao Laravel 7</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará

Seja bem vindo ao Laravel 7

## Rota que trabalha com variáveis
```php
Route::get('/', function () {
  $nome = 'Ribamar FS';
  return '<h1>Seja bem vindo ao Laravel 7 '.$nome.'</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará na tela:

Seja bem vindo ao Laravel 7 Ribamar FS

## Nomear uma rota que chama uma view
```php
Route::get('sobre', function() {
    return view('paginas.sobre');
})->name('sobre');
```
Esta rota funciona assim, quando alguém digita sobre na URL ela chama a view sobre que está dentro da pasta paginas.

Ainda não trataremos de views.

## Definindo paginação
```php
    Route::get('produtos', function () {
        return view('produtos.index')
            ->with('produtos', Produto::paginate(20));
    });
```
Usualmente a paginação é definida no controller, action index(), mas pode até ser definido na rota.

## Chamando action de controller

Route::get('index','ProdutoController@index');

## Redirecionando
```php
// Para um controller/action
Route::get('/', function(){
  return redirect()->action('ProdutoController@index');
});

// Para uma view
Route::get('/', function(){
  return redirect('produtos.index');
});

// Voltar para a URL de onde veio
Route::get('/', function(){
  return redirect()->back();
});
```
## Renomeando uma rota com as

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);

## Principais verbos de rotas

## Tipos de routes
```php
HTTP	  Ação
get		  leitura
post	  gravação
put		  atualização
delete	delete
```
## Retornar um array para a url que solicitou
```php
Route::get('/medicos', function () {
    $medicos = [
      'Antônio',
      'João',
      'Pedro'
    ];
    return $medicos;
});
```
## Então chamar

php artisan serve

localhost:8000

## Mostrará

Os 3 nomes

## Simplificando a estrita de uma função anônima/closure:
```php
Primeira etapa:
Route::get('/', function(){});

Segunda etapa:
Route::get('/', function(){

});
```
## Passando parâmetros para uma view

Passando informações da rota para a view
```php
Route::get('/', function () {
    $nome = 'Ribamar FS';
    return view('welcome', ['nome'=>$nome]);
});
```
## Alterar a view
resources/views/welcome.blade.php, substituindo Laravel por
```php
                <div class="title m-b-md">
                    <h3>Meu nome é: {{ $nome }}</h3>
                </div>

Route::get('nome', function(){
  $info = [
    $nome = 'Ribamar FS',
    $idade = 63
  ];
  return view('novo', $info)
});
```
## Na view novo:

echo 'Meu nome é '. $nome . ' e tenho '.$idade;

## Outra
```php
Route::get('nome', function(){
  return view('novo', ['nome' => 'Ribamar FS']);
});

Ou
Route::get('nome', function(){
   return view('novo')->with('nome' => 'Ribamar FS');
});
```
## Na view novo:
echo 'Meu nome é '. $nome;

## Passagem de parâmetro
```php
Route::get('dados/{id_usuario}', function($id_usuario){
  return view('dados')->with('id_usuario', $id_usuario);
});
```
## Passar vários parâmetros
```php
Route::get('dados/{id_usuario}/{id_consulta}', function($id_usuario, $id_consulta){
  return view('dados')->with('id_usuario', $id_usuario)->with('id_consulta', $id_consulta);
});
```
Chegará na views dados: $id_usuario e $id_consulta, caso sejam passado pela url os dois parâmetros exemplo:

http://localhost:8000/id1/id2

## Valor default de parâmetro
```php
Route::get('dados/{id?}', function($id=null){ // null ou 0 ou outro valor
  return view('dados')->with('id', $id);
});
```
## Exemplo de rotas tipo resource
```php
Rota resource substitui todas as abaixo:

Route::resource('/produtos', 'ProdutoController');

Route::get('/produtos/{id}/edit', 'ProdutoController@edit')->name('produtos.edit');
Route::put('/produtos/{id}', 'ProdutoController@update')->name('produtos.update');
Route::get('/produtos/create', 'ProdutoController@create')->name('produtos.create');
Route::get('/produtos/{id}', 'ProdutoController@show')->name('produtos.show');
Route::get('/produtos', 'ProdutoController@index')->name('produtos.index');
Route::post('/produtos', 'ProdutoController@store')->name('produtos.store');
Route::delete('/produtos/{id}', 'ProdutoController@destroy')->name('produtos.destroy');

Similar
Route::get('produtos', 'ProdutosController@index');
Route::get('produtos/create', 'ProdutosController@create');
// Para store
Route::post('produtos/create', 'ProdutosController@store');
Route::get('produtos/{idProd}', 'ProdutosController@show');
Route::get('produtos/{idProd}/{idProd2}', 'ProdutosController@showTwo');
Route::get('produtos/edit/{idProd}', 'ProdutosController@edit');
```
## Rota para receber qualquer tipo
```php
Route::any('any', function () {
    return 'Rota qualquer';
});
```
## Agrupando rotas
```php
Route::group(['prefix' => 'painel', 'middleware' => 'auth'], function((){
	Route::get('/', function(){
		return view('painel.home.index');
	})
	Route::get('financeiro', function(){
		return view('painel.financeiro.index');
	})
	Route::get('usuarios', function(){
		return view('painel.usuarios.index');
	})
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/Admin', function () { //ADM ADM

        return "Seu ID: " . Auth::user()->id . " Você é ADM";

    })->name('admin');

    Route::get('/Usuario', function () { //USER USER

        return "Seu ID: " . Auth::user()->id . " Você é Usuario";

    })->name('usuario');

    Route::get('/semLogar', function () { // SEM LOGAR

        return "Você não está autenticado";

        })->name('semLogar');

    Route::get('/login/admin',['middleware' => 'Check:admin','uses' => 'AdminController@index', 'as' => 'indexAdm']);
});
```

## Auenticação
```php
Route::get('profile', 'UserController@show')->middleware('auth');

Route::get('/admin', function(){
  Return 'Admin';
})->middleware('auth');

Route::middleware(['auth']), group(function(){
  Route::get('/admin/contab', function(){
    Return 'Admin Contabilidade';
  });

  Route::get('/admin/geren', function(){
    Return 'Admin Gerência';
  });

  Route::get('/admin/engen', function(){
    Return 'Admin Engenharia';
  });
)};

Route::middleware(['auth'])->group(function(){
  Route::prefix('admin')->group(function(){
    Route::namespace('Admin')->group(function(){
      Route::get('/contab', 'TesteController@contab');
      Route::get('/geren', 'TesteController@geren');
      Route::get('/engen', 'TesteController@enge');
    });
  });
)};

Route::get('user/{user}', [
	'middleware' => ['auth', 'roles'], // A 'roles' middleware must be specified
	'uses' => 'UserController@index',
	'roles' => ['administrator', 'manager'] // Only an administrator, or a manager can access this route
]);
```
## Usando expressões regulares
```php
Route::get('gatos/{id}', function($id) {
  sprintf('Gato #%d', $id);
})->where('id', '[0-9]+');

Route::get('users/{id}', function ($id) {
//
})->where('id', '[0-9]+');
Route::get('users/{username}', function ($username) {
//
})->where('username', '[A-Za-z]+');
Route::get('posts/{id}/{slug}', function ($id, $slug) {
//
})->where(['id' => '[0-9]+', 'slug' => '[A-Za-z]+']);
```
## Chamar view e passar variável para ela
```php
Route::get('tasks', function () {
  return view('tasks.index')
    ->with('tasks', Task::all());
});
```
## Com muito código
```php
Route::get('dogs', function (Request $request) {
  // Grab the query parameter and turn it into an array exploded by ,
  $sorts = explode(',', $request->input('sort', ''));

  // Create a query
  $query = Dog::query();

  // Add the sorts one by one
  foreach ($sorts as $sortCol) {
    $sortDir = starts_with($sortCol, '-') ? 'desc' : 'asc';
    $sortCol = ltrim($sort, '-');
    $query->orderBy($sortCol, $sortDir);
  }

  // Return
  return $query->paginate(20);
});
```
## Enviando informação para uma view
```php
use App\Cliente;// Isso requer a classe model criada

Route::get('/', function () {
    $clientes = Cliente::all();
    foreach($clientes as $cliente){
      $nome = $cliente['nome'];
    }
    return view('welcome', ['nome' => $nome]);
});
```
## Na view
                    <h3>Meu nome é: {{ $nome }}</h3>
## Usando namespace
```php
Route::get('page', [\App\Http\Controllers\PageController::class, 'action']);
```

## Limitando requisições através de rotas
```php
Limitndo requisições nas rotas

// maximum of 10 requests for guests, 60 for authenticated users
Route::middleware('throttle:10|60,1')->group(function () {
    //
});
```

## Acessar somente alguns actions
```php
Route::resource('photo', 'PhotoController', ['only' => [
    'index', 'show'
]]);

Route::resource('photo', 'PhotoController', ['except' => [
    'create', 'store', 'update', 'destroy'
]]);
```

## Validação via rules
```php
use App\Cliente;

Route::post('clientes', function()
{
    // processamento do form

    // criar as regras de validação
    $rules = array(
			'nome' => 'required|min:3|max:45',
			'cpf' => 'min:11|max:11|unique:clientes',
			'nascimento' => 'nullable|date|date_format:Y-m-d'
	        'email' => 'required|email|unique:clientes',
    );

    // fazer a validação
    // validar contra os inputs do form
    $validator = Validator::make(Input::all(), $rules);

    // checar se a validação falhou
    if ($validator->fails()) {

        // receber as mensagens de erro do validador
        $messages = $validator->messages();

        // redirecionar nosso user de volta para o form com os erros do validador
        return Redirect::to('clientes')
            ->withErrors($validator);

    } else {
        // validação bem sucedida

        // nosso cliente passou em todos os testes
        // deixe ele entrar no banco de dados

        // criar os dados para o nosso cliente
        $cliente = new Cliente;
        $cliente->nome     = Input::get('nome');
        $cliente->cpf    = Input::get('cpf');
        $cliente->nascimento     = Input::get('nascimento');
        $cliente->email    = Input::get('email');


        // salvar nosso cliente
        $cliente->save();

        // redirecionar nosso user de volta para o form para que ele repita tudo
        return Redirect::to('clientes');
    }

});
```

## Permissões
// Permitir user com permissão de acesso para ver a página
```php
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => 'access',
    'uses' => 'MyController@myAction'
]);

// Permitir user com permissão de acesso ou admin para ver a página
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => ['access', 'admin'],
    'uses' => 'MyController@myAction'
]);

// Permitir user com permissão de acesso e admin para ver a página
Route::get('/test', [
    'middleware' => ['auth', 'permissions.required'],
    'permissions' => ['access', 'admin'],
    'permissions_require_all' => true,
    'uses' => 'MyController@myAction'
]);
```
## Forçar o uso do HTTPS na rota
```php
Route::filter('https', function(){
  if(Request::secure())
  return Redirect::secure(URI::current());
});
```

# Usando Rotas no Laravel 7

Uma rota é uma ponte entre o mundo externo e a nossa aplicação. Uma forma de usuários que extão distantes ou mesmo na mesma máquina acessarem recursos da nossa aplicação. É composta por uma URL e pelo código para atender a essa URL.

Rotas são a parte do aplicativo que o programador prepara para responder a certas URLs que o usuário poderá solicitar ou então a links.
O caso mais usual de rotas e recomendado, simplificando, o aplicativo recebe uma solicitação de url, as rotas previamente preparadas recebem o pedido/requisição/request e o passam para um controller. O controller interage com o model, o model vai ao banco de dados, então o model devolve as devidas informações ao controller.O controller pode efetuar algumas operações, como verificação de autenticação, validação, etc. Então o controller passa o resultado final para a respectiva view. A view devolve ao usuário que as solicitou.

As rotas fazem o mapeamento entre as urls e os recursos do aplicativo.

Mas existe uma grande variedade de usos das rotas.

Nós veremos a seguir diversos exemplos de uso de rotas.

Na versão 7 do laravel as rotas ficam em:

routes/web.php

Existem outros tipos de rotas mas aqui lidaremos apenas com as web.

## Editar a rota default e deixar assim:
```php

Route::get(url: '/artigos', action: 'ArtigoController@index');

Route::get(url: '/artigos', [\App\Http\Controllers\ArtigoController::class, 'index']);

ou
use App\Http\Controllers\ArtigoController;
Route::get(url: '/artigos', [ArtigoController, 'index']);

Route::get('/', function () {
    return '<h1>Seja bem vindo ao Laravel 7</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará

Seja bem vindo ao Laravel 7

## Rota que trabalha com variáveis
```php
Route::get('/', function () {
  $nome = 'Ribamar FS';
  return '<h1>Seja bem vindo ao Laravel 7 '.$nome.'</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará na tela:

Seja bem vindo ao Laravel 7 Ribamar FS

## Renomeando uma rota com as

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);

## Principais verbos de rotas

## Tipos de routes
```php
HTTP	  Ação
get		  leitura/acesso a uma página
post	  gravação no bd
put		  atualização no bd
delete	  delete no bd

GET - /products | index
GET - /products/10 | show
GET - /products/10/edit | edit
GET - /products/create | create
POST - /products | store
PUT ou PATCH - /products/10 | update
DELETE - /products/10 | destroy
```
## Retornar um array para a url que solicitou
```php
Route::get('/medicos', function () {
    $medicos = [
      'Antônio',
      'João',
      'Pedro'
    ];
    return $medicos;
});
```
## Então chamar

php artisan serve

localhost:8000

## Mostrará

Os 3 nomes

## Passagem de parâmetro
```php
Route::get('dados/{id_usuario}', function($id_usuario){
  return view('dados')->with('id_usuario', $id_usuario);
});
```
## Passar vários parâmetros
```php
Route::get('dados/{id_usuario}/{id_consulta}', function($id_usuario, $id_consulta){
  return view('dados')->with('id_usuario', $id_usuario)->with('id_consulta', $id_consulta);
});
```
Chegará na views dados: $id_usuario e $id_consulta, caso sejam passado pela url os dois parâmetros exemplo:

http://localhost:8000/id1/id2

## Valor default de parâmetro
```php
Route::get('dados/{id?}', function($id=null){ // null ou 0 ou outro valor
  return view('dados')->with('id', $id);
});
```

## Rota para receber qualquer tipo
```php
Route::any('any', function () {
    return 'Rota qualquer';
});
```
## Usando namespace
```php
Route::get('page', [\App\Http\Controllers\PageController::class, 'action']);
```
## Acessar somente alguns actions
```php
Route::resource('photo', 'PhotoController', ['only' => [
    'index', 'show'
]]);

Route::resource('photo', 'PhotoController', ['except' => [
    'create', 'store', 'update', 'destroy'
]]);
```
## Forçar o uso do HTTPS na rota
```php
Route::filter('https', function(){
  if(Request::secure())
  return Redirect::secure(URI::current());
});
```

# Usando Rotas no Laravel 7

Uma rota é uma ponte entre o mundo externo e a nossa aplicação. Uma forma de usuários que extão distantes ou mesmo na mesma máquina acessarem recursos da nossa aplicação. É composta por uma URL e pelo código para atender a essa URL.

Rotas são a parte do aplicativo que o programador prepara para responder a certas URLs que o usuário poderá solicitar ou então a links.
O caso mais usual de rotas e recomendado, simplificando, o aplicativo recebe uma solicitação de url, as rotas previamente preparadas recebem o pedido/requisição/request e o passam para um controller. O controller interage com o model, o model vai ao banco de dados, então o model devolve as devidas informações ao controller.O controller pode efetuar algumas operações, como verificação de autenticação, validação, etc. Então o controller passa o resultado final para a respectiva view. A view devolve ao usuário que as solicitou.

As rotas fazem o mapeamento entre as urls e os recursos do aplicativo.

Mas existe uma grande variedade de usos das rotas.

Nós veremos a seguir diversos exemplos de uso de rotas.

Na versão 7 do laravel as rotas ficam em:

routes/web.php

Existem outros tipos de rotas mas aqui lidaremos apenas com as web.

## Editar a rota default e deixar assim:
```php

Route::get(url: '/artigos', action: 'ArtigoController@index');

Route::get(url: '/artigos', [\App\Http\Controllers\ArtigoController::class, 'index']);

ou
use App\Http\Controllers\ArtigoController;
Route::get(url: '/artigos', [ArtigoController, 'index']);

Route::get('/', function () {
    return '<h1>Seja bem vindo ao Laravel 7</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará

Seja bem vindo ao Laravel 7

## Rota que trabalha com variáveis
```php
Route::get('/', function () {
  $nome = 'Ribamar FS';
  return '<h1>Seja bem vindo ao Laravel 7 '.$nome.'</h1>';
});
```

## Então chamar

php artisan serve

localhost:8000

## Mostrará na tela:

Seja bem vindo ao Laravel 7 Ribamar FS

## Renomeando uma rota com as

Route::get('/admin', ['as' => 'admin', 'uses' => 'AdminController@index']);

## Principais verbos de rotas

## Tipos de routes
```php
HTTP	  Ação
get		  leitura/acesso a uma página
post	  gravação no bd
put		  atualização no bd
delete	  delete no bd

GET - /products | index
GET - /products/10 | show
GET - /products/10/edit | edit
GET - /products/create | create
POST - /products | store
PUT ou PATCH - /products/10 | update
DELETE - /products/10 | destroy
```
## Retornar um array para a url que solicitou
```php
Route::get('/medicos', function () {
    $medicos = [
      'Antônio',
      'João',
      'Pedro'
    ];
    return $medicos;
});
```
## Então chamar

php artisan serve

localhost:8000

## Mostrará

Os 3 nomes

## Passagem de parâmetro
```php
Route::get('dados/{id_usuario}', function($id_usuario){
  return view('dados')->with('id_usuario', $id_usuario);
});
```
## Passar vários parâmetros
```php
Route::get('dados/{id_usuario}/{id_consulta}', function($id_usuario, $id_consulta){
  return view('dados')->with('id_usuario', $id_usuario)->with('id_consulta', $id_consulta);
});
```
Chegará na views dados: $id_usuario e $id_consulta, caso sejam passado pela url os dois parâmetros exemplo:

http://localhost:8000/id1/id2

## Valor default de parâmetro
```php
Route::get('dados/{id?}', function($id=null){ // null ou 0 ou outro valor
  return view('dados')->with('id', $id);
});
```

## Rota para receber qualquer tipo
```php
Route::any('any', function () {
    return 'Rota qualquer';
});
```
## Usando namespace
```php
Route::get('page', [\App\Http\Controllers\PageController::class, 'action']);
```
## Acessar somente alguns actions
```php
Route::resource('photo', 'PhotoController', ['only' => [
    'index', 'show'
]]);

Route::resource('photo', 'PhotoController', ['except' => [
    'create', 'store', 'update', 'destroy'
]]);
```
## Forçar o uso do HTTPS na rota
```php
Route::filter('https', function(){
  if(Request::secure())
  return Redirect::secure(URI::current());
});
```

Route::group(['middleware' => 'role:developer'], function() {

   Route::get('/admin', function() {

      return 'Welcome Admin';
      
   });

});

Route::get('/posts/delete', 'PostController@delete')->middleware('can:isAdmin')->name('post.delete');
  
Route::get('/posts/update', 'PostController@update')->middleware('can:isManager')->name('post.update');
  
Route::get('/posts/create', 'PostController@create')->middleware('can:isUser')->name('post.create');



