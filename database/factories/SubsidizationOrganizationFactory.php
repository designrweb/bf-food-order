<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Company;
use App\SubsidizationOrganization;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(SubsidizationOrganization::class, function (Faker $faker) {

    return [
        'name'       => $faker->company,
        'zip'        => $faker->postcode,
        'city'       => $faker->city,
        'street'     => $faker->streetName,
        'company_id' => factory(Company::class),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
        'deleted_at' => null,
    ];
});
