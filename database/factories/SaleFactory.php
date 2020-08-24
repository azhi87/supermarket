<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Sale;
use App\User;
use Faker\Generator as Faker;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'type' => $faker->randomElement(['sale', 'returned_sale']),
        'dinars' => $faker->numberBetween(1000, 120000),
        'dollars' => $faker->randomNumber(2),
        'discount' => $faker->randomNumber(1),
        'total' => $faker->randomNumber(),
        'rate' => 1250,
        'calculatedPaid' => $faker->randomNumber(3),
        'description' => $faker->text(300),
        'status' => $faker->randomElement(['0', '1'])
    ];
});
