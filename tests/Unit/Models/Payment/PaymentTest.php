<?php


namespace Tests\Unit\Models\Payment;


use App\Order;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @test */
    public function payment_is_created_after_order_save()
    {
        $order = factory(Order::class)->create();

        $this->assertDatabaseCount('payments', 1);

        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function it_do_after_pre_order_save()
    {
        $order = factory(Order::class)->create([
            'type'                          => Order::TYPE_PRE_ORDER,
//            'menuitem_id'                   => factory(MenuItem::class),
//            'consumer_id'                   => factory(Consumer::class),
//            'day'                           => $faker->date(),
//            'pickedup'                      => $faker->boolean,
//            'pickedup_at'                   => $faker->dateTime(),
            'quantity'                      => 1,
            'is_subsidized'                 => null,
            'subsidization_organization_id' => null,
        ]);

    }
    /** @test */
    public function it_do_after_pos_order_save()
    {
        $order = factory(Order::class)->create([
            'type'                          => Order::TYPE_POS_ORDER,
//            'menuitem_id'                   => factory(MenuItem::class),
//            'consumer_id'                   => factory(Consumer::class),
//            'day'                           => $faker->date(),
//            'pickedup'                      => $faker->boolean,
//            'pickedup_at'                   => $faker->dateTime(),
            'quantity'                      => 2,
            'is_subsidized'                 => null,
            'subsidization_organization_id' => null,
        ]);

    }

    /** @test */
    public function it_do_after_voucher_order_save()
    {
        $order = factory(Order::class)->create([
            'type'                          => Order::TYPE_VOUCHER_ORDER,
//            'menuitem_id'                   => factory(MenuItem::class),
//            'consumer_id'                   => factory(Consumer::class),
//            'day'                           => $faker->date(),
//            'pickedup'                      => $faker->boolean,
//            'pickedup_at'                   => $faker->dateTime(),
            'quantity'                      => 2,
            'is_subsidized'                 => null,
            'subsidization_organization_id' => null,
        ]);

    }
}
