<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\SubsidizationOrganization;
use App\SubsidizationRule;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(SubsidizationRule::class, function (Faker $faker) {

    return [
        'rule_name'       => $faker->name,
        'subsidization_organization_id' => factory(SubsidizationOrganization::class),
        'start_date' => Carbon::now()->subDays(10),
        'end_date' => Carbon::now()->addDays(10),
        'created_by' => factory(User::class),
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
});
