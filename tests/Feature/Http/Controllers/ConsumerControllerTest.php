<?php

namespace Tests\Feature\Http\Controllers;

/**
 * @group controller
 */
use App\Consumer;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConsumerControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $this->markTestIncomplete();
        $response = $this->get(route('consumers.index'));

        $response->assertOk();
        $response->assertViewIs('consumers.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('consumers.create'));

        $response->assertOk();
        $response->assertViewIs('consumers._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $consumer = create(Consumer::class);

        $response = $this->get(route('consumers.show', $consumer));

        $response->assertOk();
        $response->assertViewIs('consumers.view');
        $response->assertViewHas('resource', $consumer);
    }

    /** @test */
    public function edit_returns_view()
    {
        $consumer = create(Consumer::class);

        $response = $this->get(route('consumers.edit', $consumer));

        $response->assertOk();
        $response->assertViewIs('consumers._form');
        $response->assertViewHas('resource', $consumer);
    }
}
