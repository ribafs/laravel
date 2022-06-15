<?php

use Illuminate\Support\Facades\Route;

Route::get('funcionarios', 'FuncionarioController@index'); // Devolve uma view contendo uma lista
Route::get('funcionarios/create', 'FuncionarioController@create'); // Devolve uma view com form vazio
Route::post('funcionarios/store', 'FuncionarioController@store'); // Salva info no DB
Route::get('funcionarios/{id}/edit', 'FuncionarioController@edit'); // Devolve uma view com form preenchido
Route::get('funcionarios/{id}/show', 'FuncionarioController@show');
Route::put('funcionarios/{id}/update', 'FuncionarioController@update'); // Salva alterações no DB
Route::delete('funcionarios/{id}/destroy', 'FuncionarioController@destroy');// Remove registros do DB

// Lembre que usaremos diretamente somente as rotas do tipo get, as demais serão usadas pelo sistema.
Chamamos
- create que chamará store
- edit que chamará update
- index/delete que chamará destroy

Estas 3 citadas acima são usadas apenas pelo sistema.

