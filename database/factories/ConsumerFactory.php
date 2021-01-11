<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\LocationGroup;
use App\User;
use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(Consumer::class, function (Faker $faker) {
    return [
        'account_id'        => $faker->unique()->randomNumber(6),
        'firstname'         => $faker->firstName,
        'lastname'          => $faker->lastName,
        'birthday'          => $faker->date(),
        'imageurl'          => null,
        'balance'           => $faker->numberBetween(200, 2000),
        'balance_limit'     => $faker->numberBetween(10, 50),
        'location_group_id' => factory(LocationGroup::class),
        'user_id'           => factory(User::class),
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
        'deleted_at'        => null,
    ];
});
