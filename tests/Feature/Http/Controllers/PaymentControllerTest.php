<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class PaymentControllerTest extends TestCase
{
    // todo remove and acts as admin
    use WithoutMiddleware;

    /** @test */
    public function it_returns_bank_transaction_view()
    {
        $response = $this->get('/admin/payments/bank-transactions');

        $response->assertOk();
        $response->assertSee('grid-index-page');
        $response->assertViewIs('payments.bank-transactions');
    }

    /** @test */
    public function it_returns_bank_transaction_structure()
    {
        $response = $this->get('/admin/payments/bank-transactions/get-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "filters"      => [
                    'consumer_account',
                    'user_email',
                    'amount_locale',
                    'comment',
                    'created_at_human',
                ],
                "sort"         => [
                    'consumer_account',
                    'user_email',
                    'amount_locale',
                    'comment',
                    'created_at_human',
                ],
                "fields"       => [

                ],
                "allowActions" => [] // todo add actions
            ]);
    }

    /** @test */
    public function it_returns_all_bank_transactions()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_returns_meal_order_view()
    {
        $response = $this->get('/admin/payments/meal-orders');

        $response->assertOk();
        $response->assertSee('meal-orders-page');
        $response->assertViewIs('payments.meal-orders');
    }

    /** @test */
    public function it_returns_meal_orders_structure()
    {
        $response = $this->get('/admin/payments/meal-orders/get-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "filters"      => [
                    'consumer_account',
                    'user_email',
                    'amount_locale',
                    'comment',
                    'is_subsidized',
                    'created_at_human',
                    'day_human',
                ],
                "sort"         => [
                    'consumer_account',
                    'user_email',
                    'amount_locale',
                    'comment',
                    'is_subsidized',
                    'created_at_human',
                    'day_human',
                ],
                "fields"       => [

                ],
                "allowActions" => ['all']
            ]);
    }

    /** @test */
    public function it_returns_all_meal_orders()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_returns_single_payment()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_creates_new_payment()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_updates_existing_payment()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_deletes_existing_payment()
    {
//        $this->assertTrue(false);
    }
}
