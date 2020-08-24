<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Item;
use App\Manufacturer;
use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'barcode' => $faker->numberBetween(1200000, 525522222),
        'sale_price' => $faker->numberBetween(1000, 75000),
        'sale_price_id' => $faker->numberBetween(1000, 75000),
        'items_per_box' => $faker->numberBetween(1, 10),
        'purchase_price' => $faker->numberBetween(0.5, 25),
        'description' => $faker->paragraph(1),
        'category_id' => function () {
            return factory(Category::class)->create();
        },
        'supplier_id' => function () {
            return factory(Supplier::class)->create();
        },
        'manufacturer_id' => function () {
            return factory(Manufacturer::class)->create();
        },
        'sale_price_discount' => $faker->numberBetween(0, 10),
        'status' => $faker->randomElement(['1', '0']),
        'maxzan' => $faker->numberBetween(10, 30),
        'name' => $faker->streetName,
        'name_en' => $faker->name(),
    ];
});
