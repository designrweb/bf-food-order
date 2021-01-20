<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MenuCategory;
use App\MenuItem;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(MenuItem::class, function (Faker $faker) {

    return [
        'name'              => $faker->word,
        'availability_date' => $faker->date(),
        'description'       => $faker->paragraph,
        'menu_category_id'  => factory(MenuCategory::class),
        'imageurl'          => null,
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
    ];
});
