<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\MenuCategory;
use App\MenuItem;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(MenuItem::class, function (Faker $faker) {

    return [
        'name'              => $faker->word,
        'availability_date' => $faker->date(),
        'location_id'       => factory(Location::class),
        'description'       => $faker->paragraph,
        'menu_category_id'  => factory(MenuCategory::class),
        'imageurl'          => $faker->image(),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
