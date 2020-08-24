<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payback;
use App\Supplier;
use App\User;
use Faker\Generator as Faker;

$factory->define(Payback::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'discount' => $faker->randomDigitNotNull,
        'currency' => $faker->randomElement(['IQD', '$']),
        'paid' => $faker->numberBetween(10, 2000),
        'supplier_id' => function () {
            return factory(Supplier::class)->create();
        },
        'description' => $faker->paragraph()
    ];
});
