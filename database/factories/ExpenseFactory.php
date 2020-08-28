<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use App\User;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'amount' => $faker->numberBetween(250, 300000),
        'reason' => $faker->paragraph(1),
        'currency' => $faker->randomElement(['$', 'IQD'])
    ];
});
