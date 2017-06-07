<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(App\Entities\Usuario::class, function (Faker\Generator $faker) {
    $tipos = [
        \App\Entities\Enumeration\TipoUsuario::$RECEPCIONISTA,
        \App\Entities\Enumeration\TipoUsuario::$ADMINISTRADOR
    ];

    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('minhasenha'),
        'tipo' => $tipos[array_rand($tipos)]
     ];
});