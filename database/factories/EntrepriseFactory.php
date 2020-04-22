<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Entreprise;
use Faker\Generator as Faker;

$factory->define(Entreprise::class, function (Faker $faker) {
    return [
        'numRegistre' => 'xxx',
        'type' => 'H',
        'numEnregistre' => 'xxx',
        'entreprise' => $faker->company,
        'idPays' => 201,
        'sigle' => 'xx',
        'adresse' => $faker->streetAddress,
        'telephone' => $faker->e164PhoneNumber,
        'fax' => 'xx',
        'website' => 'xx',
        'boitePostale' => $faker->postcode,
        'dateCreation' => date('Y-m-d', random_int(0, 1583856373)),
    ];
});
