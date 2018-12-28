<?php

$factory->define(App\Model\Product\Image::class, function (Faker\Generator $faker) {
    return [
        'url' => $faker->imageUrl(200, 200)
    ];
});
