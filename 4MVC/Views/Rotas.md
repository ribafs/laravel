# Rotas

## Criar uma rota
Route::get('user', ['as' => 'user.index', uses =>] 'UserController@index');

## No controller
```php
public function index(){
  return view('user.index');
}
```
## Links para rotas em view
```php
      <li class="nav-item active">
        <a class="nav-link" href="{{ URL::to('/engenharia') }}">Engenharia <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('/contabilidade') }}">Contabilidade <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ URL::to('/ti') }}">TI <span class="sr-only">(current)</span></a>
      </li>
```

## Outra forma

<a href="{{ url('/home') }}">Home</a>

<a href="{{ route('login') }}">Login</a>

Para usar a última forma a rota precisa ser nomeada

Route::get('/login', 'HomeController@login')->name('login');


