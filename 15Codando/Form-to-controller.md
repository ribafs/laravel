# Enviar dados de um formulário para um controller

## Rota

Route::get('show', 'UsuarioController@show');

## View

formulario.blade.php

```php
<form method="POST" action="store">
{{ csrf_file() }}
Usuário<input type="text" name="usuario">
Senha<input type="password" name="senha">
<input type="submit" value="Enviar">
</form>
```

## Controller

php artisan make:controller UsuarioController

```php
// Para acessar a view
public function show(){
  return view('formulario');
}

// Para receber os dados do form
public function store(Request $dados){
  return view('formulario');
}
```
## Criar a respectiva rota

Route::post('store', 'UsuarioController@store');

## Alterando algo

apagar o controller Usuario

php artisan make:controller UsuarioController --resource

## Rota

Route::resource('usuarios', 'UsuarioController');
```php
<form method="POST" action="clientes">
{{ csrf_file() }}
Usuário<input type="text" name="usuario">
Senha<input type="password" name="senha">
<input type="submit" value="Enviar">
</form>

public function index(){
  return view('formulario');
}

public function store(Request $data){
  $usuario = $data->usuario;
  $senha = $data->senha;
  $token = $data->_token;

  echo "Usuário: $usuario<br>Senha: $senha";
}
```

