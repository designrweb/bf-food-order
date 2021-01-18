<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\MenuCategory;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(MenuCategory::class, function (Faker $faker) {
    $price = $faker->randomFloat(10, 3, 6);

    return [
        'name'           => $faker->word,
        'category_order' => $faker->numberBetween(1, 10),
        'price'          => $price,
        'presaleprice'   => $price - 2,
        'location_id'    => factory(Location::class),
        'created_at'     => Carbon::now(),
        'updated_at'     => Carbon::now(),
    ];
});
