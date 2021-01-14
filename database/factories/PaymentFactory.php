<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\Order;
use App\Payment;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

$factory->define(Payment::class, function (Faker $faker) {
    $paymentTypes = [
        Payment::TYPE_BANK_TRANSACTION,
        Payment::TYPE_MANUAL_TRANSACTION,
        Payment::TYPE_VOUCHER,
        Payment::TYPE_PRE_ORDER,
        Payment::TYPE_PRE_ORDER_CANCELLATION,
        Payment::TYPE_PRE_ORDER_SUBSIDIZED,
        Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND,
        Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION,
        Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND,
        Payment::TYPE_POS_ORDER,
        Payment::TYPE_POS_ORDER_SUBSIDIZED,
        Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND,
    ];

    return [
        'amount'        => $faker->randomFloat(),
        'type'          => $paymentTypes[array_rand($paymentTypes)],
        'comment'       => $faker->paragraph(1),
        'order_id'      => factory(Order::class),
        'consumer_id'   => factory(Consumer::class),
        'created_at'    => Carbon::now(),
        'updated_at'    => Carbon::now(),
        'transacted_at' => Carbon::now(),
    ];
});
