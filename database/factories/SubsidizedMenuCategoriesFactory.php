<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MenuCategory;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(SubsidizedMenuCategories::class, function (Faker $faker) {

    return [
        'subsidization_rule_id' => factory(SubsidizationRule::class),
        'menu_category_id' => factory(MenuCategory::class),
        'percent' => $faker->numberBetween(50, 100),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
