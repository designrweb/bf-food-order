<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Location;
use App\LocationGroup;
use Faker\Generator as Faker;

$factory->define(LocationGroup::class, function (Faker $faker) {
    return [
        'location_id' => factory(Location::class),
        'name'       => $faker->word,
    ];
});
