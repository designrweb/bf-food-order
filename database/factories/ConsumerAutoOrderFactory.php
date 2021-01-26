<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\ConsumerAutoOrder;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(ConsumerAutoOrder::class, function (Faker $faker) {
    return [
        'consumer_id' => factory(Consumer::class),
        'is_active'   => $faker->boolean,
        'created_at'  => Carbon::now(),
        'updated_at'  => Carbon::now(),
    ];
});
