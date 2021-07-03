<?php

use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/index', function () {
    return view('empresa.index');
});

Route::get('/show', function () {
    return view('empresa.show');
});

Route::get('/edit', function () {
    return view('empresa.edit');
});

