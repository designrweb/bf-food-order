<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PaymentDump;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(PaymentDump::class, function (Faker $faker) {
    $paymentDumpTypes = [
        PaymentDump::STATUS_UPLOADED,
        PaymentDump::STATUS_PROCESSED,
        PaymentDump::STATUS_DUPLICATED,
    ];

    return [
        'file_name'    => 'test-dump.csv',
        'status'       => $paymentDumpTypes[array_rand($paymentDumpTypes)],
        'created_at'   => Carbon::now(),
        'updated_at'   => Carbon::now(),
        'requested_at' => null,
    ];
});
