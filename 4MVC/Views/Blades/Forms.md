# Formulários

## Value guardar o valor digitado

<input type="text" name="username" value="{{ old('username') }}">

## Caminho de layout, regra:

viewa/dir1/dir2/nome.blade.php

dir1.dir2.nome

## Exemplo de form
```php
@extends('admin.layouts.app')

@section('title', 'Cadastrar novo produto')

@section('content')
  <h1>Cadastrar novo produto</h1>
  <form action="" method="post">
  {{csrf_field()}} {!! Todo formulário precisa vir com o csrf!!}
  </form>
@endsection
```
## Links nas views

<a href="{{route('produtos.create') }}">Novo Produto</a>

Quando um form com método post não é aceito criar um input hidden

<input type="hidden" name="_method" value="PUT"

ou

@method('PUT') dentro do form

## Pegando os valores anteriores (da sessão) dos campos de form

<input type="text" name="name" value="{{}old(name)}"

Criar includes para cada tipo de campo: text, password, email, submit, etc 

E montar o form com o abreform, os includes e o fechaform

Exemplo

https://www.youtube.com/watch?v=dafh5mL1wWw&list=PLw6ZnC_OJcva1PZgT_cdURU2pX0Eh6_nt&index=28

select.blade.php
```php
<label class="{{$class ?? null}}">
{!! Form::select($select, []) !!}
</label>

<form method="POST" action="/profile">
    @csrf

    ...
</form>

HTML pode executar requests PUT, PATCH, or DELETE
<form action="/foo/bar" method="POST">
    @method('PUT')

    ...
</form>

<!-- /resources/views/auth.blade.php -->

<label for="email">Email address</label>

<input id="email" type="email" class="@error('email', 'login') is-invalid @enderror">

@error('email', 'login')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```
## Criar includes de inputs de formulários

Criar a pasta

resources/views/templates/forms

Dentro dela criar os arquivos: text, password, select e submit

text.blade.php contendo
```php
@php
	$attributes['placeholder'] = $attributes['placeholder'] ?? $label;
@endphp
<label class="{{ $class ?? null }}">
	<span>{{ $label ?? $input ?? "ERRO" }}</span>
	{!! Form::text($input, $value ?? null, $attributes) !!}
</label>
```
## password.blade.php contendo
```php
<label class="{{ $class ?? null }}">
	<span>{{ $label ?? $input ?? "ERRO" }}</span>
	{!! Form::password($input, $attributes) !!}
</label>

select.blade.php contendo

<label class="{{ $class ?? null }}">
	<span>{{ $label ?? $select ?? "ERRO" }}</span>
	{!! Form::select($select, $data ?? [], $value ?? null, $attributes) !!}
</label>

submit.blade.php

<label class="{{ $class ?? null }} submit">
	{!! Form::submit($input) !!}
</label>
```
## Na dúvida da existência de uma view

@includeIf('view.name', ['some' => 'data'])

## Incluir se expressão true

@includeWhen($boolean, 'view.name', ['some' => 'data'])

Ambos os métodos do seu AppServiceProvider:

use Illuminate\Support\Facades\Blade;

Blade::include('includes.input', 'input');

Once the include has been aliased, you may render it using the alias name as the Blade directive:

@input(['type' => 'email'])


## Mostrando erros numa view
```php
@if($errors->any())
  <ul>
    @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>
@endif
```
## Exibir mensagens de erro
```php
<!-- /resources/views/post/create.blade.php -->

<label for="title">Post Title</label>

<input id="title" type="text" class="@error('title') is-invalid @enderror">

@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror
```

## Criar select vindo do banco:
```php
<select id="role" class="form-control" name="role" required>
    @foreach($roles as $id => $role)
        <option value="{{$id}}">{{$role}}</option>
    @endforeach
</select>
```

## Views - camada de apresentação, que mostra os dados para o usuário, geralmente como HTML

Para usar facade de Forms e HTML no laravel 5 execute:

composer require Collective\Html

composer require laravelcollective/html

Agora podemos criar forms assim:
```php
{!! Form::open([
    'route' => 'tasks.store'
]) !!}

<div class="form-group">
    {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
    {!! Form::text('title', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::label('description', 'Description:', ['class' => 'control-label']) !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

{!! Form::submit('Create New Task', ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}

if(view()->exists('clientes.store')){

}

{{ $nome or 'Valor Default'}}
```
## Dados sem caracteres de scape

Olá, {!! $nome !!}

## Formato de data

echo with($var)->format('d/m/Y H:i');


Apresentar error em formulários
```php
@if(count($errors) !=)
// dd($errors);
  @foreach($errors->all() as $error)
    <p class="alert alert-danger">$error</p>
  @endforeach
@endif

<form>
<label for="email">Email address</label>
<input id="email" type="email" class="@error('email', 'login') is-invalid @enderror">
<label for="senha">Senha</label>
<input id="senha" type="password" class="@error('senha', 'senha') is-invalid @enderror">
</form>
```

## Customizando as mensagens
```php
$messages = [
    'required' => 'The :attribute field is required.',
];

$validator = Validator::make($input, $rules, $messages);

$messages = [
    'same' => 'The :attribute and :other must match.',
    'size' => 'The :attribute must be exactly :size.',
    'between' => 'The :attribute value :input is not between :min - :max.',
    'in' => 'The :attribute must be one of the following types: :values',
];

$messages = [
    'email.required' => 'We need to know your e-mail address!',
];
```
https://laravel.com/docs/7.x/validation#working-with-error-messages

Uma boa ideia é criar um include para erros que será incluído em cada form

Exemplo

includes/errors.blade.php
```php
@if(count($errors) !=)
// dd($errors);
  @foreach($errors->all() as $error)
    <p class="alert alert-danger">$error</p>
  @endforeach
@endif

@if($errors->any())
     @foreach($errors->all() as $error)
      {{ $error }}
    @endforeach 
 @elseif(session()->has('success'))
       {{ session('success') }}
 @endif

public function messages(){
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser preenchido com valores numéricos.',
            'nome.min' => 'O campo :attribute requer um mínimo de :min caracteres.',
            'descricao.max' => 'O campo :attribute não pode exceder :max caracteres.'
        ];
    }
```
## Criptografia

Adicionar ao controller

use Illuminate\Supporte\Facades\Hash;
```php
public function login(){
  $senha = Hash::make($request->senha);
// Testando
  return ($request->senha .'-'.$senha);
}

$senha = Hash::make('abc123');
```
## Processo de gravação de senha
- digitar no formulário create e qenviará para o action store
- No store a senha é criptografada
- Então o hash é enviado para o banco de dados


