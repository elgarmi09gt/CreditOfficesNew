<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Classe;
use Faker\Generator as Faker;

$factory->define(Classe::class, function (Faker $faker) {
    return [
        'classe'        => $faker->name,
        'idSupclasse'   => 1000,
        'codeClasse'    => $faker->sentence(5,true),
        'nature'        => $faker->randomElement(array('actif','passif','charge','produit')),
        'systemeClasse' => $faker->randomElement(array('sb','sh')),
        'typeClasse'    => $faker->randomElement(array('new','old')),
    ];
});