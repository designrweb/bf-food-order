<?php

namespace Tests\Unit\Models\Order\Factory;

use App\Observers\OrderObserver;
use App\Order;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class OrderFactoryTest extends TestCase
{
    /** @test */
    public function order_factory_persists_one_entity_to_database()
    {
        $order = factory(Order::class)->create([
            'menuitem_id'                   => 1,
            'day'                           => '2020-12-07',
            'subsidization_organization_id' => null,

        ]);

        $this->assertDatabaseCount($order->getTable(), 1);

        $this->assertDatabaseHas($order->getTable(), [
            'day' => '2020-12-07',
        ]);
    }

    /** @test */
    public function order_factory_persists_many_entities_to_database()
    {
        factory(Order::class, 10)->create();

        $this->assertDatabaseCount('companies', 10);
    }

    // todo move to another test case
    /** @test */
    function order_created_event_is_triggered()
    {
        Event::fake([
            OrderObserver::class
        ]);

        $order = factory(Order::class)->create();
//        $order = Order::create();

        Event::assertDispatched(OrderObserver::class);
    }

    // todo move to another test case
    /** @test */
    public function createAndDispatchEvent() {
        // we turned-off any event-listener except CreatedEvent::class
        Event::fake([
            OrderObserver::class
        ]);
        $payload = [
            "name" => "foo",
            "email" => "foo@bar.com"
        ];
        $response = $this->json('POST', 'api/member', $payload);
        Event::assertDispatched(OrderObserver::class);
    }
}
