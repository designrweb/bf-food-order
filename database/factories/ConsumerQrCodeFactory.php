<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\ConsumerQrCode;
use Faker\Generator as Faker;

$factory->define(ConsumerQrCode::class, function (Faker $faker) {
    return [
        'consumer_id' => factory(Consumer::class),
        'qr_code_hash'   => $faker->word(),
    ];
});
