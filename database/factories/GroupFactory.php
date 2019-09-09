<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Groups;
use Faker\Generator as Faker;

$factory->define(Groups::class, function (Faker $faker) {
    return [
        'id' => $faker->randomDigit,
        'name' => $faker->unique()->firstName,
        'created_by' => $faker->randomDigit
    ];
});
