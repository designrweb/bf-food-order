<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\ConsumerSubsidization;
use App\SubsidizationRule;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(ConsumerSubsidization::class, function (Faker $faker) {
    return [
        'subsidization_rules_id' => factory(SubsidizationRule::class),
        'consumer_id'            => factory(Consumer::class),
        'subsidization_start'    => Carbon::now()->addDays(1),
        'subsidization_end'      => Carbon::now()->addDays(20),
        'subsidization_document' => null,
        'created_at'             => Carbon::now(),
        'updated_at'             => Carbon::now(),
        'deleted_at'             => null,
    ];
});
