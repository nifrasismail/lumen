<?php

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'sku' => $faker->unique()->randomNumber(5),
        'price' => $faker->numberBetween(100,200),
        'description' => $faker->text(100),
        'qty' =>$faker->numberBetween(10,20)
    ];
});
