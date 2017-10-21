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

/** @var \Doctrine\ORM\EntityManagerInterface $em */
$em = resolve(\Doctrine\ORM\EntityManagerInterface::class);

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

$factory->define(\App\Entities\Cidade::class, function(Faker\Generator $faker) {
    return [
        'nome' => $faker->city,
    ];
});

$factory->define(\App\Entities\Cliente::class, function(Faker\Generator $faker) use($em) {
    $generos = [
        \App\Entities\Enumeration\Sexo::$MASCULINO,
        \App\Entities\Enumeration\Sexo::$FEMININO
    ];
    return [
        'nome' => $faker->name,
        'email' => $faker->safeEmail,
        'telefone' => $faker->phoneNumber,
        'celular' => $faker->phoneNumber,
        'profissao' => $faker->jobTitle,
        'nacionalidade' => $em->getRepository(\App\Entities\Pais::class)->find(rand(1, 246)),
        'dataNascimento' => $faker->dateTimeAD,
        'dni' => $faker->bankAccountNumber,
        'cpf' => $faker->bankAccountNumber,
        'genero' => $generos[array_rand($generos)],
        'endereco' => $faker->address,
        'cidade' => $em->getRepository(\App\Entities\Cidade::class)->find(rand(1, 48314)),
        'observacoes' => $faker->text(200)
    ];
});

$factory->define(\App\Entities\Quarto::class, function(Faker\Generator $faker) use($em) {
    $tiposQuartos = $em->getRepository(\App\Entities\TipoQuarto::class)->findAll();
    return [
        'numero' => $faker->numberBetween(1,12),
        'andar' => $faker->numberBetween(1,3),
        'tipoQuarto' => $tiposQuartos[array_rand($tiposQuartos)]
    ];
});