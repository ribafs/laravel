# Rotas no Laravel 8

## Parâmetros em rotas

Route::get('foo/{bar}', function($bar){});
Route::get('foo/{bar?}', function($bar = 'bar'){});

Routing diagram
Inside route definition file (routes/web.php)

Defining a route using closure

Route::get('/', function () {
    return view('welcome');
});

Defining a route that only renders a Blade template

Route::view('/home'); // Without parameters
Route::view('/home', ['data' => 'value']); // With parameters

Route with a required parameter

Route::get('/page/{id}', function ($id) {
    return view('page', ['page' => $id]);
});

// Using Arrow Functions (Since PHP 7.4)
Route::get('/page/{id}', fn ($id) => view('page', ['page' => $id]));

Route with an optional parameter

Route::get('/hello/{name?}', function ($name = 'Guest') {
    return view('hello', ['name' => $name]);
});

// Using Arrow Functions (Since PHP 7.4)
// For optional route parameter {name}, the Closure argument has to have a default value provided
Route::get('/hello/{name?}', fn ($name = 'Guest') => view('hello', ['name' => $name]));

Named route (to give the route a name, you would chain a name() method call)

Route::view('/home')->name('home');

Generating URI of the named route (generating links)

// Without parameters
$url = route('home'); // Generates /home

// With parameters
$blogPostUrl = route('blog-post', ['id' => 1]); // Generates /blog-post/1

Inside Blade template

Defining a section

@section('content')
	<h1>Header</h1>
@endsection

Rendering a section

@yield('content')

Extending a layout

@extends('layout')

Function to render a view

view('name', ['data' =>‚ 'value'])

Rendering data inside a Blade template

{{ $data }}

By default data is escaped using htmlspecialchars

Rendering unescaped data

{!! $data !!}

Including another view

@include('view.name')

Included view will inherit parent view data

Passing additional data to included view

@include('view.name', ['name' => 'John'])

Generating a URL inside view

<a href="{{ route('home') }}">Home</a>
https://github.com/piotr-jura-udemy/laravel-cheat-sheet/blob/master/docs/0002-routes-views.md


Protegendo rotas


```php
Route::get('/settings', function () {
    // ...
})->middleware(['password.confirm']);

Route::post('/settings', function () {
    // ...
})->middleware(['password.confirm']);
```

