<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Broken;
use App\Item;
use App\User;
use Faker\Generator as Faker;

$factory->define(Broken::class, function (Faker $faker) {
    return [
        'item_id' => factory(Item::class)->create(),
        'quantity' => $faker->numberBetween(1, 100),
        'exp' => $faker->date(),
        'user_id' => factory(User::class)->create(),
        'description' => $faker->text(150)
    ];
});
