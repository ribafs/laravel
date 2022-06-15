# Exemplo de rotas

Usei a estrutura gerada pelo crud-generator: rotas, model, controller e views.
Acontece que resolvi remover a rota do tipo resource e criar uma a uma.
Para isso tive que fazer adaptações nos actions dos formulários das views e em alguns lisks:

## Roteiro de execução

- Instalar o Laravel

- Copiar toda esta estrutura para o aplicativo criado:
Copiar
Route::get('funcionarios', 'FuncionarioController@index'); // Devolve uma view contendo uma lista
Route::get('funcionarios/create', 'FuncionarioController@create'); // Devolve uma view com form vazio
Route::post('funcionarios/store', 'FuncionarioController@store'); // Salva info no DB
Route::get('funcionarios/{id}/edit', 'FuncionarioController@edit'); // Devolve uma view com form preenchido
Route::get('funcionarios/{id}/show', 'FuncionarioController@show');
Route::put('funcionarios/{id}/update', 'FuncionarioController@update'); // Salva alterações no DB
Route::delete('funcionarios/{id}/destroy', 'FuncionarioController@destroy');// Remove registros do DB

Para routes/web.php

- Copiar Funcionario.php para app/

- Copiar FuncionarioController.php para app/Http/Controllers

- Copiar 2020_08_12_154104_create_funcionarios_table.php para databases/migrations

- Copiar FuncionariosTableSeeder.php e DatabaseSeeder.php para databases/seeds

- Copiar toda a pasta funcionarios para resources/views

## Detalhes sobre as rotas

```html
index.blade.php
Link View
<a href="{{ url('/funcionarios/' . $item->id.'/show') }}" View</button></a>

Link Edit
<a href="{{ url('/funcionarios/' . $item->id . '/edit') }}" Edit</button></a>

Form Delete
<form method="POST" action="{{ url('/funcionarios' . '/' . $item->id.'/destroy') }}">

create.blade.php
<form method="POST" action="{{ url('/funcionarios/store') }}

edit.blade.php
<form method="POST" action="{{ url('/funcionarios/' . $funcionario->id.'/update') }}">

show.blade.php
<form method="POST" action="{{ url('funcionarios' . '/' . $funcionario->id.'/destroy') }}">
```
Veja que a rota encaminha para certos links ou actions da view e precisa estar de acordo com os referidos links.

## A rota citada aqui abaixo tem as URL

Route::get('funcionarios/{id}/edit', 'FuncionarioController@edit'); // Devolve uma view com form preenchido
Route::get('funcionarios/{id}/show', 'FuncionarioController@show');
Route::put('funcionarios/{id}/update', 'FuncionarioController@update'); // Salva alterações no DB
Route::delete('funcionarios/{id}/destroy', 'FuncionarioController@destroy');// Remove registros do DB

Que esperam links na forma url/id/action, isso por que nas respectivas views os links estão assim.

## Caso queira pode alterar esta ordem, por exemplo, ficando assim:

Route::get('funcionarios/edit/{id}', 'FuncionarioController@edit'); // Devolve uma view com form preenchido
Route::get('funcionarios/show/{id}', 'FuncionarioController@show');
Route::put('funcionarios/update/{id}', 'FuncionarioController@update'); // Salva alterações no DB
Route::delete('funcionarios/destroy/{id}', 'FuncionarioController@destroy');// Remove registros do DB

Mas precisará ajustar os respectivos links nas views.


