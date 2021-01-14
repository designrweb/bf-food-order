<?php

namespace Tests\Unit\Models\Order\Relation;

use App\Consumer;
use App\MenuCategory;
use App\MenuItem;
use App\Order;
use App\Payment;
use App\SubsidizationOrganization;
use Tests\TestCase;

/**
 * @group relation
 */
class OrderRelationTest extends TestCase
{
    /** @test */
    public function order_belongs_to_consumer()
    {
        $consumer = create(Consumer::class);
        $order    = create(Order::class, [
            'consumer_id' => $consumer->id
        ]);

        $this->assertEquals(1, $order->consumer->count());
        $this->assertInstanceOf(Consumer::class, $order->consumer);
    }

    /** @test */
    public function order_belongs_to_menu_item()
    {
        $menuItem = create(MenuItem::class);
        $order    = create(Order::class, [
            'menuitem_id' => $menuItem->id
        ]);

        $this->assertEquals(1, $order->menuItem->count());
        $this->assertInstanceOf(MenuItem::class, $order->menuItem);
    }

    /** @test */
    public function order_belongs_to_menu_category()
    {
        $menuCategory = create(MenuCategory::class);

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id
        ]);

        $order = create(Order::class, [
            'menuitem_id' => $menuItem->id
        ]);

        $this->assertEquals(1, $order->menuCategory->count());
        $this->assertInstanceOf(MenuCategory::class, $order->menuCategory);
    }

    /** @test */
    public function order_belongs_to_subsidization_organization()
    {
        $subsidizationOrganization = create(SubsidizationOrganization::class);
        $order                     = create(Order::class, [
            'subsidization_organization_id' => $subsidizationOrganization->id
        ]);

        $this->assertEquals(1, $order->subsidizationOrganization->count());
        $this->assertInstanceOf(SubsidizationOrganization::class, $order->subsidizationOrganization);
    }

    /** @test */
    public function order_has_many_payments()
    {
        $order   = create(Order::class);
        $payment = create(Payment::class, [
            'order_id' => $order->id
        ]);

        $this->assertTrue($order->payments->contains($payment));
        $this->assertEquals(1, $order->payments->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $order->payments);
    }
}
