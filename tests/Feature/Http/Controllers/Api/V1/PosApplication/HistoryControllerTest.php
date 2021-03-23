<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\MenuCategory;
use App\MenuItem;
use App\Order;
use Carbon\Carbon;
use Tests\TestCase;

/**
 * @group pos_api_controller
 */
class HistoryControllerTest extends TestCase
{
    /** @test */
    public function it_should_forbid_an_unauthenticated_user_to_retrieve_history()
    {
        $response = $this->getJson('/api/v1/pos/history');

        $response->assertUnauthorized();
        $response->assertExactJson([
            "message" => "Unauthorized",
            "status"  => 401
        ]);
    }

    /** @test */
    public function it_returns_history_available_for_today()
    {
        $date = Carbon::now();

        $posManager = $this->actingAsPosManager();

        $menuCategoryOne = create(MenuCategory::class, [
            'price'       => 4.55,
            'location_id' => $posManager->location_id,
            'name'        => 'Menu 3',

        ]);

        $menuItemFirst = create(MenuItem::class, [
            'availability_date' => $date,
            'menu_category_id'  => $menuCategoryOne->id,
        ]);

        $orderFirst = create(Order::class, [
            'type'        => Order::TYPE_VOUCHER_ORDER,
            'quantity'    => 2,
            'menuitem_id' => $menuItemFirst->id,
            'consumer_id' => null,
            'pickedup'    => 1,
            'pickedup_at' => $date
        ]);

        $response = $this->getJson('/api/v1/pos/history');

        $response->assertOk();
        $response->assertExactJson([
            [
                'foodorder_id' => $orderFirst->id,
                'type'         => Order::TYPES[Order::TYPE_VOUCHER_ORDER],
                'menuitem'     => $menuItemFirst->name,
                'categoryName' => $menuCategoryOne->name,
                'quantity'     => $orderFirst->quantity,
                'total'        => 9.10,
                'consumer'     => 'Anonim',
                'pickedup_at'  => date('H:i', strtotime($date)),
            ]
        ]);
    }
}
