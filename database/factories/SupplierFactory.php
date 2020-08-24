<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'mobile' => $faker->phoneNumber
    ];
});
