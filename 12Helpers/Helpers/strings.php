<?php

// Documentação oficial - https://laravel.com/docs/8.x/helpers#Strings

use Illuminate\Support\Str;

function camel($str){
    return Str::camel($str);
}

function snake($str){
    return Str::snake($str);
}

function length($str){
    return Str::length($str);
}

function limit($str){
    return Str::limit($str);
}

function lower($str){
    return Str::lower($str);
}

function upper($str){
    return Str::upper($str);
}

function ufirst($str){
    return Str::ucfirst($str);
}

function plural($str){
    return Str::plural($str);
}

function singular($str){
    return Str::singular($str);
}

function random($str){
    return Str::random($str);
}

function subst($str, $start, $finish){
    return Str::substr($str, $start, $finish);
}

