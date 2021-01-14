<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Company::class, function (Faker $faker) {

    return [
        'name'       => $faker->company,
        'zip'        => $faker->postcode,
        'city'       => $faker->city,
        'street'     => $faker->streetName,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
