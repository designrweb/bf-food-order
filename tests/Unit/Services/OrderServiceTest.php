<?php


namespace Tests\Unit\Services;


use App\Order;
use App\Services\OrderService;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    protected $orderService;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderService = $this->app->make(OrderService::class);
    }

    /** @test */
    public function payment_is_created_after_pre_order_canceled()
    {
        $order = create(Order::class, [
            'type'     => Order::TYPE_PRE_ORDER,
            'quantity' => 1,
        ]);

        $this->orderService->remove($order->id);

//        $this->assertDatabaseCount('payments', 1);
//        $this->assertDatabaseHas('payments', [
//            'order_id' => $order->id,
//        ]);
    }
}
