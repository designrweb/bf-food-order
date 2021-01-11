<?php

namespace Tests\Unit\Models\Payment\Relation;

use App\Consumer;
use App\Order;
use App\Payment;
use Tests\TestCase;

/**
 * @group relation
 */
class PaymentRelationTest extends TestCase
{
    /** @test */
    public function payment_belongs_to_consumer()
    {
        $consumer = create(Consumer::class);
        $payment = create(Payment::class, [
            'consumer_id' => $consumer->id
        ]);

        // todo fix two dependencies in payment
//        $this->assertEquals(1, $payment->consumer->count());
        $this->assertInstanceOf(Consumer::class, $payment->consumer);
    }

    /** @test */
    public function payment_belongs_to_order()
    {
        $order    = create(Order::class);
        $payment = create(Payment::class, [
            'order_id' => $order->id
        ]);

        $this->assertEquals(1, $payment->order->count());
        $this->assertInstanceOf(Order::class, $payment->order);
    }

    /** @test */
    public function payment_does_not_have_direct_user_relation()
    {
        $payment = create(Payment::class);

        $this->assertEmpty($payment->user);
    }

    /** @test */
    public function payment_does_not_have_direct_location_relation()
    {
        $payment = create(Payment::class);

        $this->assertEmpty($payment->location);
    }
}
