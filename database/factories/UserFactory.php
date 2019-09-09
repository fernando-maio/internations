<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Users;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Users::class, function (Faker $faker) {
    return [
        'id' => $faker->randomDigit,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'id_profile' => 1,
        'active' => 1,
        'blocked' => 0,
        'remember_token' => Str::random(10)
    ];
});
