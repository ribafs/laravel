# Blades

Em qualquer página de view do Blade, você geralmente coloca os dados dentro de chaves: {{$ data-> body}}. Essas instruções são enviadas automaticamente através da função htmlspecialchars do PHP para que evite ataques XSS para que os dados sejam escapados.

Se você não deseja escapar de dados, use esta sintaxe: {!! $ data-> body !!}. Mas seja cuidadoso com a entrada do usuário. É sempre uma boa prática escapar dos dados fornecidos pelos usuários.

Os dados de entrada do usuário devem ser exibidos usando chaves duplas: {{$ user-> data}}.

## Layouts/Templates

É importante entender a integração das views com o layout e includes e também das tags do Blade

- Primeiro nós temos um layout ou templae contendo alguma formatação HTML, title, utf8, includes de CSS e JavaScript e com algumas @section e @yield

- Em cada uma das views nós extendemos o layout

@extends('pasta.nomelayout')

- Nas views definimos as @section e @yield

- Exemplos de section: header, menu, content, footer

<p>Total de usuários em PHP: <?php echo count($usuarios); ?></p>

<p>Total de usuários em BLADE: {{ count($usuarios) }}</p>

As variáveis no blade usam htmlspecialchar, portanto blade é mais simples e mais seguro que php puro.

## @section - Mostra uma seção de conteúdo, como o <sction> do HTML

## @yeld - mostra o conteúdo de uma seção definida antes

## Template

<!-- Stored in resources/views/templates/master.blade.php -->

## Definir página filha

<!-- Stored in resources/views/filha.blade.php -->

Para importar o tempalte master para a filha usar

@extends('templates.master')

Criar algumas sections em filha que preencherão @yields na master
```php
@section('title', 'Valor Default')
  Título
@endsection

<html>
    <head>
        <title>Nome do Aplicativo - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')
            Seção principal do sidebar.
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

@php
//Trecho em php
@endphp

@yield('content', View::make('view.name'))
```
## Exibindo dados
```php
Route::get('greeting', function () {
    return view('welcome', ['name' => 'samantha']);
});
```
Tempo UNIX atual é {{ time() }}.

## Mostrando dados não escapados
{!! $name !!}. (Evitar isso)

## Comentários (sem espaços entre {{ e --
{{-- This comment will not be present in the rendered HTML Ctrl+U --}}

Detalhes em: https://laravel.com/docs/7.x/blade

## Mostrar variável numa view usando htmlspecialchar

{{ $variavel }}

## Sem proteção (usar somente quando conhecer o conteúdo)

{!! $variavel !!}

No template

@yield('title')

Na view

@section('title', '| Criar novo Post');

https://www.youtube.com/watch?v=9E0Tff4xeMo&list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY&index=30

{{ date('Y') }}

## Criar uma blade passo a passo:
https://www.youtube.com/watch?v=yOKw6PwYCB4&list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY&index=24
https://laravel.com/docs/7.x/blade#introduction

@section('content')

## Includes

## Criar o arquivo a ser incluido em viwes
templates/include.blade.php

## Dentro de uma @section de uma view
@include('teste.include')

ou

@include('teste.include', ['frase'=>'Frase a ser mostrada'])

## No conteúdo do arquivo podemos fazer:

<p>Existente {{$frase}}</p>

ou

<p>Existente {{$frase ?? ''}}</p>

https://laravelcollective.com/docs/6.0/html

composer require laravelcollective/html

## Criar index.blade.php e adicionar
```php
@extends('site.template')

@section('content')

<h1>Home page do site</h1>

{{$var1 or 'Não existe'}}

@endsection
```

## Includes

@include('site.includes.sidebar', compact('var1'))

https://www.youtube.com/watch?v=4RQX3nLBx8E&index=9&list=PLVSNL1PHDWvR3PeLXz6nvBkDhv1IQk4wP

## Criando includes

### Criar template

resources/views/templates\master.blade.php - aqui fica tudo que for repetido nas views, como head e algumas seções
resources/views/templates\menu.blade.php - aqui fica o menu que será mostrado em todas as views

master.blade.php conterá, por exemplo:
```php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>>@yeld('title')</title>
    <link rel="stylesheet" href="{{ assets( 'custom.css') }}">
    @yeld('css-view')
</head>
<body>
@yeld('content-view')    

@yeld('js-view')        
</body>
</html>
```
## Criar a dashboard.blade.php que herdará a master
```php
@extends('templates.master')

  @section('content-view')

  $endsection

  @section('css-view')

  $endsection

  @section('js-view')

  @endsection
```
## Criar variável no controller

### E acessar na view

### Num método do controller
```php
$title = 'Título do Aplicativo';
return view('welcome', [
  'title' => $title
]);
```
## Na view index.blade.php

<title>Laravel {{ $title }}</title>

## Chamar pelo navegador
```php
@canany(['update', 'view', 'delete'], $post)
    // The current user can update, view, or delete the post
@elsecanany(['create'], \App\Post::class)
    // The current user can create a post
@endcanany

<ul>
  @foreach ($pages as $page)
  <li>{{ $loop->iteration }}: {{ $page->title }}
    @if ($page->hasChildren())
    <ul>
    @foreach ($page->children() as $child)
      <li>{{ $loop->parent->iteration }}.
        {{ $loop->iteration }}:
        {{ $child->title }}</li>
    @endforeach
    </ul>
    @endif
  </li>
  @endforeach
</ul>
```
Blades
```php
@foreach ($users as $user)
     @if ($loop->first)
        This is the first iteration.
     @endif

     @if ($loop->last)
        This is the last iteration.
     @endif

     <p>This is user {{ $user->id }}</p>
@endforeach

@foreach ($users as $user)
    @foreach ($user->posts as $post)
        @if ($loop->parent->first)
            This is first iteration of the parent loop.
        @endif
    @endforeach
@endforeach

Valor default para campos de formulários:
{{ old('campoNome') }}

if (view()->exists('custom.page')) {
 // Load the view
}

@if(auth()->user())
    // The user is authenticated.
@endif

@auth
    // The user is authenticated.
@endauth

@guest
    // The user is not authenticated.
@endguest

@canany(['update', 'view', 'delete'], $post)
    // The current user can update, view, or delete the post
@elsecanany(['create'], \App\Post::class)
    // The current user can create a post
@endcanany
```

Five Useful Laravel Blade Directives

https://laravel-news.com/five-useful-laravel-blade-directives 

Checar se user está autenticado

@if(auth()->user())
    // The user is authenticated.
@endif

ou
@auth
    // The user is authenticated.
@endauth

Checar se user é guest (não autenticado)

@if(auth()->guest())
    // The user is not authenticated.
@endif

@guest
    // The user is not authenticated.
@endguest

@guest
    // The user is not authenticated.
@else
    // The user is authenticated.
@endguest


Incluir a primeira view se ela existir ou a segunda senão

@if(view()->exists('first-view-name'))
    @include('first-view-name')
@else
    @include('second-view-name')
@endif

ou
@includeFirst(['first-view-name', 'second-view-name']);

Incluir view baseado em uma condição

@if($post->hasComments())
    @include('posts.comments')
@endif

ou
@includeWhen($post->hasComments(), 'posts.comments');

Incluir view se existir

@if(view()->exists('view-name'))
    @include('view-name')
@endif

ou
@includeIf('view-name')

https://laravel.com/docs/8.x/blade#introduction



