<?php

namespace Tests\Unit\Models\Order\Scope;

use App\Location;
use App\MenuCategory;
use App\MenuItem;
use App\Order;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_orders()
    {
        create(Order::class, [], 5);

        $orders = Order::all();

        $this->assertEquals(5, $orders->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $orders);
    }

    /** @test */
    public function it_returns_orders_that_belongs_to_admin_company()
    {
        $admin = $this->actingAsAdmin();

        create(Order::class, [
            'menuitem_id' => create(MenuItem::class, [
                'menu_category_id' => create(MenuCategory::class, [
                    'location_id' => create(Location::class, [
                        'company_id' => $admin->company->id
                    ])
                ]),
            ])
        ], 3);

        create(Order::class, [], 2);

        $this->assertDatabaseCount('orders', 5);

        $orders = Order::all();

        $this->assertEquals(3, $orders->count());
    }

    /** @test */
    public function it_returns_orders_that_belongs_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        create(Order::class, [
            'menuitem_id' => create(MenuItem::class, [
                'menu_category_id' => create(MenuCategory::class, [
                    'location_id' => $posManager->location_id
                ]),
            ])
        ], 2);

        create(Order::class, [], 3);

        $this->assertDatabaseCount('orders', 5);

        $orders = Order::all();

        $this->assertEquals(2, $orders->count());
    }
}
