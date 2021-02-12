<?php

namespace Tests\Feature\Http\Controllers;

/**
 * @group controller
 */
use App\ConsumerAutoOrder;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConsumerAutoOrderControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('consumer-auto-orders.index'));

        $response->assertOk();
        $response->assertViewIs('consumer_auto_orders.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('consumer-auto-orders.create'));

        $response->assertOk();
        $response->assertViewIs('consumer_auto_orders._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $this->markTestIncomplete();

        $autoOrder = create(ConsumerAutoOrder::class);

        $response = $this->get(route('consumer-auto-orders.show', $autoOrder));

        $response->assertOk();
        $response->assertViewIs('consumer_auto_orders.view');
        $response->assertViewHas('resource', $autoOrder);
    }

    /** @test */
    public function edit_returns_view()
    {
        $this->markTestIncomplete();

        $autoOrder = create(ConsumerAutoOrder::class);

        $response = $this->get(route('consumer-auto-orders.edit', $autoOrder));

        $response->assertOk();
        $response->assertViewIs('consumer_auto_orders._form');
        $response->assertViewHas('resource', $autoOrder);
    }
}
