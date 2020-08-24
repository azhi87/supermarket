<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Rate;
use App\User;
use Faker\Generator as Faker;

$factory->define(Rate::class, function (Faker $faker) {
    return [
        'rate' => $faker->numberBetween(118, 125),
        'user_id' => function () {
            return factory(User::class)->create();
        }
    ];
});
