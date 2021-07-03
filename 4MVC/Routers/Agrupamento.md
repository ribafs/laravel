# Agrupamento de rotas

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

