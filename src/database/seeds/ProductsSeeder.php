<?php

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Model\Product::class, 1000)->create()->each(function ($product) {
            /** @var $product app\Model\Product */
            $product->images()->saveMany(factory(App\Model\Product\Image::class, 3)->make());
        });
    }
}
