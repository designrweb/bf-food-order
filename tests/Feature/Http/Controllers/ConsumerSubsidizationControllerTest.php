<?php

namespace Tests\Feature\Http\Controllers;

/**
 * @group controller
 */

use App\ConsumerSubsidization;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ConsumerSubsidizationControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $response = $this->get(route('consumer-subsidizations.index'));

        $response->assertOk();
        $response->assertViewIs('consumer_subsidizations.index');
    }

    /** @test */
    public function create_returns_view()
    {
        $response = $this->get(route('consumer-subsidizations.create'));

        $response->assertOk();
        $response->assertViewIs('consumer_subsidizations._form');
    }

    /** @test */
    public function show_returns_view()
    {
        $consumerSubsidization = create(ConsumerSubsidization::class);

        $response = $this->get(route('consumer-subsidizations.show', $consumerSubsidization));

        $response->assertOk();
        $response->assertViewIs('consumer_subsidizations.view');
        $response->assertViewHas('resource', $consumerSubsidization);
    }

    /** @test */
    public function edit_returns_view()
    {
        $consumerSubsidization = create(ConsumerSubsidization::class);

        $response = $this->get(route('consumer-subsidizations.edit', $consumerSubsidization));

        $response->assertOk();
        $response->assertViewIs('consumer_subsidizations._form');
        $response->assertViewHas('resource', $consumerSubsidization);
    }
}
