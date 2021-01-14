<?php

namespace Tests\Unit\Models\Order\Factory;

use App\Observers\OrderObserver;
use App\Order;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @group factory
 */
class OrderFactoryTest extends TestCase
{
    /** @test */
    public function order_factory_persists_one_entity_to_database()
    {
        $order = create(Order::class, [
            'day' => '2020-12-07',
        ]);

        $this->assertDatabaseCount($order->getTable(), 1);
        $this->assertDatabaseHas($order->getTable(), [
            'day' => '2020-12-07',
        ]);
    }

    /** @test */
    public function order_factory_persists_many_entities_to_database()
    {
        create(Order::class, [], 10);

        $this->assertDatabaseCount('orders', 10);
    }
}
