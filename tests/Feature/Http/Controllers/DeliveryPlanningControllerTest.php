<?php

namespace Tests\Feature\Http\Controllers;

use App\Order;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class DeliveryPlanningControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('delivery-planning.index'));

        $response->assertOk();
        $response->assertViewIs('delivery_planning.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('delivery-planning.create'));

        $response->assertOk();
        $response->assertViewIs('delivery_planning._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $order = create(Order::class);

        $response = $this->get(route('delivery-planning.show', $order));

        $response->assertOk();
        $response->assertViewIs('delivery_planning.view');
        $response->assertViewHas('resource', $order);
    }

    /** @test */
    public function edit_returns_view()
    {
        $order = create(Order::class);

        $response = $this->get(route('delivery-planning.edit', $order));

        $response->assertOk();
        $response->assertViewIs('delivery_planning._form');
        $response->assertViewHas('resource', $order);
    }

    // todo add other methods
    //get('admin/companies/get-all');
    //get('admin/companies/get-structure');
    //get('admin/companies/get-view-structure');
    //get('admin/companies/get-one/{id}');
    //post('admin/companies/');
    //get('admin/companies/{id}/edit');
    //put('admin/companies/{id}');
    //delete('admin/companies/{id}');
}
