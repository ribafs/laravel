<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Contato::class, function (Faker $faker) {
    return [
        'saudacao' => 'Sr.',
        'nome' => $faker->name,
        'telefone' => $faker->phoneNumber,
        'nascimento' => $faker->date("Y-m-d"),
        'email' => $faker->unique()->safeEmail,
        'nota' => 'Usuário criado usando o método factory e a classe faker'
    ];
});


