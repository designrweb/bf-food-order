<?php

namespace Tests\Unit\Models\Order\Relation;

use App\Consumer;
use App\MenuItem;
use App\Order;
use App\Payment;
use App\SubsidizationOrganization;
use Tests\TestCase;

class OrderRelationTest extends TestCase
{
    /** @test */
    public function order_belongs_to_consumer()
    {
        $consumer = factory(Consumer::class)->create();
        $order    = factory(Order::class)->create(['consumer_id' => $consumer->id]);

        $this->assertEquals(1, $order->consumer->count());
        $this->assertInstanceOf(Consumer::class, $order->consumer);
    }

    /** @test */
    public function order_belongs_to_menu_item()
    {
        $menuItem = factory(MenuItem::class)->create();
        $order    = factory(Order::class)->create(['menuitem_id' => $menuItem->id]);

        $this->assertEquals(1, $order->menuItem->count());
        $this->assertInstanceOf(MenuItem::class, $order->menuItem);
    }

    /** @test */
    public function order_belongs_to_subsidization_organization()
    {
        $subsidizationOrganization = factory(SubsidizationOrganization::class)->create();
        $order                     = factory(Order::class)->create(['subsidization_organization_id' => $subsidizationOrganization->id]);

        $this->assertEquals(1, $order->subsidizationOrganization->count());
        $this->assertInstanceOf(SubsidizationOrganization::class, $order->subsidizationOrganization);
    }

    /** @test */
    public function order_has_many_payments()
    {
        $order   = factory(Order::class)->create();
        $payment = factory(Payment::class)->create(['order_id' => $order->id]);

        $this->assertTrue($order->payments->contains($payment));
        $this->assertEquals(1, $order->payments->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $order->payments);
    }
}
