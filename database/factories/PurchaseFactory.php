<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Purchase;
use App\User;
use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'type' => $faker->randomElement(['purchase', 'returned_purchase']),
        'total' => $faker->randomNumber(),
        'invoice_no' => $faker->randomNumber(5),
        'supplier_id' => function () {
            return factory(Supplier::class)->create();
        }
    ];
});
