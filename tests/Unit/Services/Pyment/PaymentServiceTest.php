<?php

namespace Tests\Unit\Services\Pyment;

use App\Order;
use App\Services\PaymentService;
use bigfood\grid\BaseModelService;
use Tests\TestCase;

class PaymentServiceTest extends TestCase
{
    protected $paymentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->paymentService = $this->app->make(PaymentService::class);
    }

    /** @test */
    public function it_create_payment_after_order()
    {
        $order          = factory(Order::class)->make();
        $this->paymentService->createPaymentBasedOnOrder($order);
    }
}
