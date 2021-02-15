<?php

namespace Tests\Unit\Services\Payment;

use App\Consumer;
use App\ConsumerSubsidization;
use App\Exceptions\WrongOrderTypeException;
use App\MenuCategory;
use App\MenuItem;
use App\Order;
use App\Payment;
use App\Services\PaymentService;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
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
    public function payment_is_created_after_pre_order_saved()
    {
        $order = create(Order::class, [
            'type'     => Order::TYPE_PRE_ORDER,
            'quantity' => 1,
        ]);

        $this->paymentService->createPaymentBasedOnOrder($order);

        $this->assertDatabaseCount('payments', 1);
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function payment_is_created_after_pos_order_saved()
    {
        $order = create(Order::class, [
            'type'     => Order::TYPE_POS_ORDER,
            'quantity' => 2,
        ]);

        $this->paymentService->createPaymentBasedOnOrder($order);

        $this->assertDatabaseCount('payments', 1);
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function payment_is_created_after_voucher_order_saved()
    {
        $order = create(Order::class, [
            'type'     => Order::TYPE_VOUCHER_ORDER,
            'quantity' => 3,
        ]);

        $this->paymentService->createPaymentBasedOnOrder($order);

        $this->assertDatabaseCount('payments', 1);
        $this->assertDatabaseHas('payments', [
            'order_id' => $order->id,
        ]);
    }

    /** @test */
    public function it_updates_consumer_balance_after_payment_based_on_order_is_created()
    {
        $consumer = create(Consumer::class, [
            'balance' => 200
        ]);

        $menuCategory = create(MenuCategory::class, [
            'price' => 25,
            'location_id' => $consumer->locationgroup->location->id
        ]);

        $order = create(Order::class, [
            'type'     => Order::TYPE_POS_ORDER,
            'quantity' => 1,
            'consumer_id' => $consumer->id,
            'subsidization_organization_id' => null,
            'menuitem_id' => create(MenuItem::class, [
                'menu_category_id' => $menuCategory->id
            ]),
        ]);

        $this->paymentService->createPaymentBasedOnOrder($order);

        $this->assertDatabaseHas('consumers', [
            'id'      => $consumer->id,
            'balance' => 175
        ]);
    }

    /** @test */
    public function it_creates_reverse_payment_for_pre_order()
    {
        // we  have menu category and menu item
        $menuCategory = create(MenuCategory::class);
        $menuItem     = create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer              = create(Consumer::class);
        $subsidizationRule     = create(SubsidizationRule::class);
        $consumerSubsidization = create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 55,
        ]);

        // we have pre order made by consumer
        $order = create(Order::class, [
            'type'        => Order::TYPE_PRE_ORDER,
            'consumer_id' => $consumer->id,
            'menuitem_id' => $menuItem->id,
            'quantity'    => 1,
        ]);

        // we have payment
        $payment = create(Payment::class, [
            'amount'      => 10,
            'order_id'    => $order->id,
            'consumer_id' => $consumer->id,
        ]);

        $this->paymentService->createReversePayment($payment, $order);

        $this->assertDatabaseCount('payments', 2);
        $this->assertDatabaseHas('payments', [
            'amount' => -5.50,
            'type'   => Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND,
        ]);
    }

    /** @test */
    public function it_creates_reverse_payment_for_pos_order()
    {
        // we  have menu category and menu item
        $menuCategory = create(MenuCategory::class);
        $menuItem     = create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer              = create(Consumer::class);
        $subsidizationRule     = create(SubsidizationRule::class);
        $consumerSubsidization = create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 50,
        ]);

        // we have pos order made by consumer
        $order = create(Order::class, [
            'type'        => Order::TYPE_POS_ORDER,
            'consumer_id' => $consumer->id,
            'menuitem_id' => $menuItem->id,
            'quantity'    => 3,
        ]);

        // we have payment
        $payment = create(Payment::class, [
            'amount'      => 12,
            'order_id'    => $order->id,
            'consumer_id' => $consumer->id,
        ]);

        $this->paymentService->createReversePayment($payment, $order);

        $this->assertDatabaseHas('payments', [
            'amount' => -2.00,
            'type'   => Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND,
        ]);
    }

    /** @test */
    public function it_properly_calculates_reverse_payment_amount_for_pre_order()
    {
        $orderQuantity = 1;
        $paymentAmount = 8;
        $percent       = 100;

        $amount = $this->paymentService->getReversePaymentAmount($orderQuantity, $paymentAmount, $percent);

        $this->assertEquals(-8, $amount);
    }

    /** @test */
    public function it_properly_calculates_reverse_payment_amount_for_pos_order()
    {
        $orderQuantity = 2;
        $paymentAmount = 10;
        $percent       = 100;

        $amount = $this->paymentService->getReversePaymentAmount($orderQuantity, $paymentAmount, $percent);

        $this->assertEquals(-5, $amount);
    }

    /** @test */
    public function it_properly_calculates_payment_amount_for_pre_order()
    {
        $orderType    = Order::TYPE_PRE_ORDER;
        $price        = 5.5;
        $presaleprice = 4.2;
        $quantity     = 1;

        $amount = $this->paymentService->getPaymentAmount($orderType, $price, $presaleprice, $quantity);

        $this->assertEquals(4.2, $amount);
    }

    /** @test */
    public function it_properly_calculates_payment_amount_for_pos_order()
    {
        $orderType    = Order::TYPE_POS_ORDER;
        $price        = 5.5;
        $presaleprice = 4.2;
        $quantity     = 3;

        $amount = $this->paymentService->getPaymentAmount($orderType, $price, $presaleprice, $quantity);

        $this->assertEquals(16.5, $amount);
    }

    /** @test */
    public function it_properly_calculates_payment_amount_for_voucher_order()
    {
        $orderType    = Order::TYPE_VOUCHER_ORDER;
        $price        = 5.5;
        $presaleprice = 4.2;
        $quantity     = 4;

        $amount = $this->paymentService->getPaymentAmount($orderType, $price, $presaleprice, $quantity);

        $this->assertEquals(0, $amount);
    }

    /** @test */
    public function trying_to_make_order_with_type_that_not_exits_throws_an_exception()
    {
        $orderType    = 7;
        $price        = 5.5;
        $presaleprice = 4.2;
        $quantity     = 4;

        try {
            $this->paymentService->getPaymentAmount($orderType, $price, $presaleprice, $quantity);
        } catch (WrongOrderTypeException $e) {
            $this->assertTrue(true);

            return;
        }
        $this->fail('Order succeeded even though there were not such type');
    }

    /** @test */
    public function pre_order_can_be_subsidized()
    {
        // we  have menu category with menu item
        $menuCategory = create(MenuCategory::class);
        $menuItem     = create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);
        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 50,
        ]);

        // we have pre order made by consumer
        $order = create(Order::class, [
            'type'        => Order::TYPE_PRE_ORDER,
            'menuitem_id' => $menuItem->id,
            'consumer_id' => $consumer->id,
            'quantity'    => 1,
        ]);

        $oldQuantityValue = 0;

        $canBeSubsidized = $this->paymentService->canBeSubsidized($order, $oldQuantityValue);

        $this->assertTrue($canBeSubsidized);
    }

    /** @test */
    public function pos_order_can_be_subsidized()
    {
        // we  have menu category with menu item
        $menuCategory = create(MenuCategory::class);
        $menuItem     = create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);
        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rule_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 50,
        ]);

        // we have pos order made by consumer
        $order = create(Order::class, [
            'type'          => Order::TYPE_POS_ORDER,
            'menuitem_id'   => $menuItem->id,
            'consumer_id'   => $consumer->id,
            'is_subsidized' => Order::IS_SUBSIDIZED,
            'quantity'      => 3,
        ]);

        $oldQuantityValue = 0;

        $canBeSubsidized = $this->paymentService->canBeSubsidized($order, $oldQuantityValue);

        $this->assertTrue($canBeSubsidized);
    }

    /** @test */
    public function it_updates_consumer_balance_after_manual_payment_is_created()
    {
        $consumer = create(Consumer::class, [
            'balance' => 200
        ]);
        $payment  = [
            'consumer_id' => $consumer->id,
            'amount'      => 10,
        ];

        $this->paymentService->create($payment);

        $this->assertDatabaseHas('consumers', [
            'id'      => $consumer->id,
            'balance' => 210
        ]);
    }
}
