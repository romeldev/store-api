<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Product;
use App\Model\Category;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $price = rand(10, 1000);
    $price_ref = rand(0,1)? $price+((rand(1, 99)/100 ))*$price : null;

    return [
        'name' => $faker->words(3, true),
        'descrip' => $faker->text(200),
        'price' => $price,
        'price_ref' => $price_ref,
        'category_id' => Category::inRandomOrder()->first(),
    ];
});
