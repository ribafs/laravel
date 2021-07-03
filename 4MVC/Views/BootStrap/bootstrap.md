# Dicas sobre o framework Bootstrap

## Classes básicas para aplicação do Bootstrap

O simples fato de adicionar o CSS no template do laravel já altera vários aspectos
```php
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
	<title>Produtos</title>
	<!-- bootstrap que acompanha o laravel/ -->
  <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <!-- Ícones-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->

</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
```

## Claro de precisamos inportar o template nas views

@extends('layout/template')

@section('content')

## Container
class="container"

## Tabela
 <table class="table table-striped table-bordered table-hover">

## Botões
class="btn btn-primary"

class="btn btn-warning"

## Form
```php
default - width: 100%;
Em label usar form-group
  <div class="form-group">
    <label for="Password">Password</label>
    <input type="password" class="form-control" id="Password" placeholder="Password">
  </div>
```
## Tamanho de campos com as classes, sem form-control
input-sm

input-lg

input
```php
/* Set widths on the form inputs since otherwise they're 100% wide */
input[type="text"],
input[type="password"],
input[type="email"],
input[type="tel"],
input[type="select"] {
    max-width: 280px;
}
```
## Form Horizontal
<form class="form-horizontal">

## Em Cada campo do form
class="form-control"

## <textarea class="form-control" rows="3"></textarea>

## Checkbox
```php
<div class="checkbox">
  <label>
    <input type="checkbox" value="">
    Option one is this and that&mdash;be sure to include why it's great
  </label>
</div>
<div class="checkbox disabled">
  <label>
    <input type="checkbox" value="" disabled>
    Option two is disabled
  </label>
</div>
```
## Radio
```php
<div class="radio">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
    Option one is this and that&mdash;be sure to include why it's great
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
    Option two can be something else and selecting it will deselect option one
  </label>
</div>
<div class="radio disabled">
  <label>
    <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled>
    Option three is disabled
  </label>
</div>
```
## Selct
```php
<select class="form-control">
  <option>1</option>
  <option>2</option>
  <option>3</option>
  <option>4</option>
  <option>5</option>
</select>
```
## Ícones
- Relógio - class="fa fa-clock-o"
- Calendário - class="fa fa-calendar"
- Usuário - class="fa fa-user"

## Linha
class="row"

## Grid - 3 colunas
class="col-sm-3"


