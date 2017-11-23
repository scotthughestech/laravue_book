<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Purchase::class, function (Faker $faker) {
    return [
        'user_id' => array_random(User::pluck('id')->toArray()),
        'date' => $faker->dateTimeThisYear()->format('Y-m-d'),
        'price' => $faker->randomFloat(2, 5, 100),
        'description' => ucfirst($faker->words(2, true))
    ];
});
