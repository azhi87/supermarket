<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use App\Stock;
use Faker\Generator as Faker;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'item_id' => factory(Item::class)->create(),
        'quantity' => $faker->numberBetween(1, 20),
        'exp' => $faker->dateTimeThisCentury(20),
        'bonus' => $faker->numberBetween(0, 10),
        'type' => $faker->randomElement(['broken', 'sale', 'purchase', 'returned_sale', 'returned_purchase']),
        'source_id' => $faker->randomNumber(1),
        'ppi' => $faker->numberBetween(1, 20),
        'rate' => $faker->numberBetween(1250, 1350),
        'description' => $faker->text(100),
        'batch_no' => $faker->word

    ];
});
