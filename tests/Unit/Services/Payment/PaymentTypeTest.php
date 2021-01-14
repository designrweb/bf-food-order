<?php

namespace Tests\Unit\Services\Payment;

use App\Order;
use App\Payment;
use App\Services\PaymentService;
use Tests\TestCase;

class PaymentTypeTest extends TestCase
{
    protected $paymentService;

    public function setUp(): void
    {
        parent::setUp();
        $this->paymentService = $this->app->make(PaymentService::class);
    }

    /** @test */
    public function payment_has_type_voucher()
    {
        $orderType = Order::TYPE_VOUCHER_ORDER;
        $paymentAmount = 0;
        $canBeSubsidized = false;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_VOUCHER, $type);
    }

    /** @test */
    public function payment_has_type_pre_order()
    {
        $orderType = Order::TYPE_PRE_ORDER;
        $paymentAmount = 4;
        $canBeSubsidized = false;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_PRE_ORDER, $type);
    }

    /** @test */
    public function payment_has_type_pre_order_cancellation()
    {
        $orderType = Order::TYPE_PRE_ORDER;
        $paymentAmount = -4.1;
        $canBeSubsidized = false;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_PRE_ORDER_CANCELLATION, $type);
    }

    /** @test */
    public function payment_has_type_pre_order_subsidized()
    {
        $orderType = Order::TYPE_PRE_ORDER;
        $paymentAmount = 3.55;
        $canBeSubsidized = true;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_PRE_ORDER_SUBSIDIZED, $type);
    }

    /** @test */
    public function payment_has_type_pre_order_subsidized_cancellation()
    {
        $orderType = Order::TYPE_PRE_ORDER;
        $paymentAmount = -5;
        $canBeSubsidized = true;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION, $type);
    }

    /** @test */
    public function payment_has_type_pos_order()
    {
        $orderType = Order::TYPE_POS_ORDER;
        $paymentAmount = 3.33;
        $canBeSubsidized = false;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_POS_ORDER, $type);
    }

    /** @test */
    public function payment_has_type_pos_order_subsidized()
    {
        $orderType = Order::TYPE_POS_ORDER;
        $paymentAmount = 4.5;
        $canBeSubsidized = true;

        $type = $this->paymentService->getPaymentType($orderType, $paymentAmount, $canBeSubsidized);

        $this->assertEquals(Payment::TYPE_POS_ORDER_SUBSIDIZED, $type);
    }

    /** @test */
    public function reverse_payment_has_type_pre_order_subsidized_refund()
    {
        $orderType   = Order::TYPE_PRE_ORDER;
        $paymentType = Payment::TYPE_PRE_ORDER_SUBSIDIZED;

        $type = $this->paymentService->getReversePaymentType($orderType, $paymentType);

        $this->assertEquals(Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND, $type);
    }

    /** @test */
    public function reverse_payment_has_type_pre_order_subsidized_cancellation_refund()
    {
        $orderType   = Order::TYPE_PRE_ORDER;
        $paymentType = Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION;

        $type = $this->paymentService->getReversePaymentType($orderType, $paymentType);

        $this->assertEquals(Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND, $type);
    }

    /** @test */
    public function reverse_payment_has_type_pos_order_subsidized_refund()
    {
        $orderType   = Order::TYPE_POS_ORDER;
        $paymentType = Payment::TYPE_PRE_ORDER_SUBSIDIZED;

        $type = $this->paymentService->getReversePaymentType($orderType, $paymentType);

        $this->assertEquals(Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND, $type);
    }
}
