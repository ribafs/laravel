# Layout com Blade

## Criar a pasta

resources/views/templates

## Criar o layout
resources/views/templates/layout.blade.php
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Título default')</title>
</head>
<body>

    {{-- menu --}}
    <div>
        @yield('menu')
    </div>
    
    {{-- content --}}
    <div>
        @yield('content')
    </div>

    {{-- footer --}}
    <div>
        @yield('footer')
    </div>
</body>
</html>
```

## Criar a view

resources/views/contato.blade.php
```php
@extends('templates.layout')

@section('title')
    {{ Título do site }}
@endsection

@section('menu')
    <p><div><a href="">Um</a><a href="">Dois</a><a href="">Três</a> </div><p>
@endsection

@section('content')
    <h1>Aqui o conteúdo</h1>
@endsection

@section('footer')
    <p>Aqui o rodapé</p>
@endsection
```
Ele traz inicialmente o layout para cá e encaixa as sections


## Criar outra view

resources/views/sobre.blade.php
```php
@extends('templates.layout')

@section('title')
    {{ Título do site }}
@endsection

@section('menu')
    <p><div><a href="">Um</a><a href="">Dois</a><a href="">Três</a> </div><p>
@endsection

@section('content')
    <h1>Aqui o conteúdo</h1>
@endsection

@section('footer')
    <p>Aqui o rodapé</p>
@endsection
```

## Funcionamento:
Ele traz inicialmente o layout para cá e encaixa nele especificamente nas yields as sections definidas nesta view.


Basta para mostrar estas views um rota, sem usar controller:
```php
Route::get('contato', function(){
  return view('contato');
});

Route::get('sobre', function(){
  return view('sobre');
});
```
Obs.: veja que o layout é um modelo em que cada view deve se espelhar, ou seja, cada view deve definir as seções do layout

O normal é usarf yield no layout e section nas views.

Mas se usar section no layout, usar show e não stop:
```php
@section('navegacao')
  Uma frase
@show
```
Já na view
```php
@section('navegacao')
  @parent
  Segunda frase
@stop
```
Ao executar aparecerá:

Uma frase

Segunda frase

A primeira vem do layout

A segunda vem da view


