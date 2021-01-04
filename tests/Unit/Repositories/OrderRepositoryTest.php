<?php

namespace Tests\Unit\Repositories;

use App\Consumer;
use App\Order;
use App\Repositories\OrderRepository;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    protected $orderRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = $this->app->make(OrderRepository::class);
    }

    /** @test */
    public function it_returns_orders_with_subsidization_by_date_for_consumer()
    {
        $consumer = factory(Consumer::class)->create();

        $subsidizedOrder       = factory(Order::class)->create([
            'type'          => Order::TYPE_PRE_ORDER,
            'consumer_id'   => $consumer->id,
            'day'           => '2021-02-02',
            'is_subsidized' => 1,
        ]);

        $notSubsidizedOrder       = factory(Order::class)->create([
            'type'          => Order::TYPE_PRE_ORDER,
            'consumer_id'   => $consumer->id,
            'day'           => '2021-02-02',
            'is_subsidized' => 0,
        ]);

        $ordersWithSubsidization = $this->orderRepository->getOrdersWithSubsidizationByDateForConsumer($subsidizedOrder);

        $this->assertEquals(1, $ordersWithSubsidization->count());
        $this->assertTrue($ordersWithSubsidization->contains($subsidizedOrder));
    }
}
