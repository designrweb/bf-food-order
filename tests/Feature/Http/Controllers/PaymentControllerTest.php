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
    public function it_returns_all_bank_transactions()
    {
//        $this->assertTrue(false);
    }

    /** @test */
    public function it_returns_meal_orders_structure()
    {
        $response = $this->get('/admin/payments/meal-orders/get-structure');

        $response
            ->assertOk()
            ->assertJsonStructure([
                "filters"      => [
                    'account',
                    'user_email',
                    'amount',
                    'comment',
                    'is_subsidized',
                    'created_at',
                    'day',
                ],
                "sort"         => [
                    'account',
                    'user_email',
                    'amount',
                    'comment',
                    'is_subsidized',
                    'created_at',
                    'day',
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
