<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email'             => $faker->unique()->safeEmail,
        'password'          => Hash::make('nKS2JW723Q'),
        'email_verified_at' => Carbon::now(),
        'remember_token'    => Str::random(10),
        'role'              => User::ROLE_ADMIN,
        'created_at'        => Carbon::now(),
        'updated_at'        => Carbon::now(),
        'deleted_at'        => null,
    ];
});
