<?php

namespace Tests\Unit\Models\MenuItem\Attribute;

use App\MenuCategory;
use App\MenuItem;
use App\Order;
use Tests\TestCase;

class CountSpontaneousItemsAttributeTest extends TestCase
{
    /** @test */
    public function it_counts_spontaneous_orders()
    {
        $menuItem = create(MenuItem::class);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_POS_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 2);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_VOUCHER_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 2);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 3);

        $spontaneousOrders = $menuItem->count_spontaneous_items;

        $this->assertEquals(12, $spontaneousOrders);
    }

    /** @test */
    public function it_counts_spontaneous_orders_for_current_pos_terminal()
    {
        $posManager = $this->actingAsPosManager();

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id
            ]),
        ]);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_POS_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 2,
        ], 2);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_VOUCHER_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 4,
        ], 2);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'pickedup'    => 1,
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 2);

        $spontaneousOrders = $menuItem->count_spontaneous_items;

        $this->assertEquals(12, $spontaneousOrders);
    }
}
