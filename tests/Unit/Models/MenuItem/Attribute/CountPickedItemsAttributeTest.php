<?php

namespace Tests\Unit\Models\MenuItem\Attribute;

use App\MenuCategory;
use App\MenuItem;
use App\Order;
use Tests\TestCase;

class CountPickedItemsAttributeTest extends TestCase
{
    /** @test */
    public function it_counts_picked_pre_orders()
    {
        $menuItem = create(MenuItem::class);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'type'        => Order::TYPE_PRE_ORDER,
            'pickedup'    => 1,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 2);

        create(Order::class, [
            'type'     => Order::TYPE_PRE_ORDER,
            'pickedup' => 1,
            'day'      => date('Y-m-d')
        ], 3);

        $pickedOrders = $menuItem->count_picked_items;

        $this->assertEquals(6, $pickedOrders);
    }

    /** @test */
    public function it_counts_picked_pre_orders_for_current_pos_terminal()
    {
        $posManager = $this->actingAsPosManager();

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id
            ]),
        ]);

        create(Order::class, [
            'menuitem_id' => $menuItem->id,
            'type'        => Order::TYPE_PRE_ORDER,
            'pickedup'    => 1,
            'day'         => date('Y-m-d'),
            'quantity'    => 3,
        ], 2);

        create(Order::class, [
            'type'     => Order::TYPE_PRE_ORDER,
            'pickedup' => 1,
            'day'      => date('Y-m-d')
        ], 3);

        $pickedOrders = $menuItem->count_picked_items;

        $this->assertEquals(6, $pickedOrders);
    }
}
