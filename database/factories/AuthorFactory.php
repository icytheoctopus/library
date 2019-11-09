<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Author;
use Faker\Generator as Faker;

$factory->define(Author::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'age' => $faker->numberBetween(15, 85),
        'address' => $faker->address,
    ];
});
