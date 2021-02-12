<?php

namespace Tests\Unit\Models\Order\Scope;

use App\Order;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeHasSubsidization extends TestCase
{
    /** @test */
    public function order_has_subsidization()
    {
        $order = create(Order::class, [
            'is_subsidized' => Order::IS_SUBSIDIZED
        ]);

        $orderWithSubsidization = Order::hasSubsidization()->first();

        $this->assertNotNull($orderWithSubsidization);
        $this->assertEquals($order->id, $orderWithSubsidization->id);
    }
}
