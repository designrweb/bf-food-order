<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\Consumer;
use App\LocationGroup;
use App\MenuCategory;
use App\MenuItem;
use App\Order;
use App\Payment;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @group pos_api_controller
 */
class OrderControllerTest extends TestCase
{
    /** @test */
    public function it_returns_order_statistic_for_current_pos_manager()
    {
        $posManager = $this->actingAsPosManager();

        $menuCategory = create(MenuCategory::class, [
            'name'        => 'Menu II',
            'location_id' => $posManager->location_id
        ]);

        $order = create(Order::class, [
            'day'         => '2021-02-05',
            'menuitem_id' => create(MenuItem::class, [
                'menu_category_id' => $menuCategory->id
            ])
        ]);

        $response = $this->getJson('/api/v1/pos/order/statistic?date=05.02.2021');

        $response->assertOk();
        $response->assertExactJson([
            "orders" => [
                $order->id => [
                    "menuCategoryName" => $menuCategory->name,
                    "preOrders"        => $order->type == Order::TYPE_PRE_ORDER ? strval($order->quantity) : 0,
                    "posOrders"        => $order->type == Order::TYPE_POS_ORDER ? strval($order->quantity) : 0,
                    "vouchers"         => $order->type == Order::TYPE_VOUCHER_ORDER ? strval($order->quantity) : 0,
                ]
            ],
            "date"   => "2021-02-05"
        ]);

    }

    /** @test */
    public function it_creates_voucher_orders_from_pos_terminal()
    {
        $posManager = $this->actingAsPosManager();

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $payload = [
            "0" => [
                "menuitem_id" => $menuItem->id,
                "type"        => 3,
                "quantity"    => 2,
            ]
        ];

        $response = $this->postJson('/api/v1/pos/order/create', $payload);

        $response->assertOk()
            ->assertExactJson([
                "message" => "Order is successfully created"
            ]);

        // todo make request instead looking into DB
        $this->assertDatabaseHas('orders', [
            'type'        => Order::TYPE_VOUCHER_ORDER,
            'menuitem_id' => $menuItem->id,
            'consumer_id' => null,
            'day'         => date('Y-m-d'),
            'pickedup'    => 1,
        ]);

        // todo make request instead looking into DB
        $this->assertDatabaseHas('payments', [
            'amount'        => 0.00,
            'type'          => Payment::TYPE_VOUCHER,
            'consumer_id'   => null,
            "transacted_at" => null
        ]);
    }

    /** @test */
    public function it_creates_spontaneous_orders_without_subsidization_from_pos_terminal()
    {
        $posManager = $this->actingAsPosManager();

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id,
                'price'       => 5
            ])
        ]);

        $consumer = create(Consumer::class, [
            'balance'           => 200,
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $payload = [
            "0" => [
                "menuitem_id"   => $menuItem->id,
                "type"          => 2,
                "quantity"      => 3,
                "consumer_id"   => $consumer->id,
                "is_subsidized" => 0,
            ],
        ];

        $response = $this->postJson('/api/v1/pos/order/create', $payload);

        $response->assertOk()
            ->assertExactJson([
                "message" => "Order is successfully created"
            ]);

        // todo make request instead looking into DB
        $this->assertDatabaseHas('orders', [
            'type'        => Order::TYPE_POS_ORDER,
            'menuitem_id' => $menuItem->id,
            'consumer_id' => $consumer->id,
            'day'         => date('Y-m-d'),
            'pickedup'    => 1,
        ]);

        // todo make request instead looking into DB
        $this->assertDatabaseHas('payments', [
            'amount'        => -15.00,
            'type'          => Payment::TYPE_POS_ORDER,
            "consumer_id"   => $consumer->id,
            "transacted_at" => null
        ]);
    }

    /** @test */
    public function it_creates_spontaneous_orders_with_subsidization_from_pos_terminal()
    {
        $this->markAsRisky();
    }

    /** @test */
    public function it_updates_pre_orders_from_pos_terminal()
    {
        $posManager = $this->actingAsPosManager();

        $menuItem = create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id,
                'price'       => 5
            ])
        ]);

        $consumer = create(Consumer::class, [
            'balance'           => 200,
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ]);

        $order = create(Order::class, [
            'type'        => Order::TYPE_PRE_ORDER,
            'menuitem_id' => $menuItem->id,
            'consumer_id' => $consumer->id,
            'pickedup'    => 0,
            'day'         => date('Y-m-d')
        ]);

        $payload = [
            "0" => [
                "menuitem_id"   => $menuItem->id,
                "type"          => 1,
                "quantity"      => 3,
                "consumer_id"   => $consumer->id,
                "is_subsidized" => 0,
            ],
        ];

        $response = $this->postJson('/api/v1/pos/order/create', $payload);

        $response->assertOk()
            ->assertExactJson([
                "message" => "Order is successfully created"
            ]);

        // todo make request instead looking into DB
        $this->assertDatabaseHas('orders', [
            'id'          => $order->id,
            'type'        => Order::TYPE_PRE_ORDER,
            'menuitem_id' => $menuItem->id,
            'consumer_id' => $consumer->id,
            'day'         => date('Y-m-d'),
            'pickedup'    => 1,
        ]);
    }

    /** @test */
    public function it_returns_information_about_orders_limit()
    {
        $posManager = $this->actingAsPosManager();

        $menuCategory = create(MenuCategory::class, [
            'name'        => 'Menu II',
            'location_id' => $posManager->location_id
        ]);

        create(Order::class, [
            'type'        => Order::TYPE_PRE_ORDER,
            'day'         => Carbon::now(),
            'pickedup_at' => Carbon::now(),
            'menuitem_id' => create(MenuItem::class, [
                'menu_category_id' => $menuCategory->id
            ])
        ]);

        $response = $this->getJson('/api/v1/pos/order/limit');

        $response->assertOk();
        $response->assertJsonStructure([
            "orders",
            "voucherLimit"
        ]);
    }
}
