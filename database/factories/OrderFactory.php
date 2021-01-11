<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Consumer;
use App\MenuItem;
use App\Order;
use App\SubsidizationOrganization;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $orderTypes = [Order::TYPE_PRE_ORDER, Order::TYPE_POS_ORDER, Order::TYPE_VOUCHER_ORDER];

    return [
        'type'                          => $orderTypes[array_rand($orderTypes)],
        'menuitem_id'                   => factory(MenuItem::class),
        'consumer_id'                   => factory(Consumer::class),
        'day'                           => $faker->date(),
        'pickedup'                      => $faker->boolean,
        'pickedup_at'                   => $faker->dateTime(),
        'quantity'                      => $faker->numberBetween(1, 3),
        'is_subsidized'                 => null,
        'subsidization_organization_id' => factory(SubsidizationOrganization::class),
        'created_at'                    => Carbon::now(),
        'updated_at'                    => Carbon::now(),
        'deleted_at'                    => null,
    ];
});
