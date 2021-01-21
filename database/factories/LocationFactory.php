<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\Location;
use Faker\Generator as Faker;

$factory->define(Location::class, function (Faker $faker) {
    return [
        'name'       => $faker->word,
        'street'     => $faker->streetName,
        'company_id' => factory(Company::class),
        'zip'        => $faker->randomNumber(5),
        'city'       => $faker->city,
        'email'      => $faker->unique()->safeEmail,
        'image_name' => null,
    ];
});
