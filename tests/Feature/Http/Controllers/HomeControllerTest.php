<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

/**
 * @group controller
 */
class HomeControllerTest extends TestCase
{
    // todo remove and interact as admin
    use WithoutMiddleware;

    /** @test */
    public function index_returns_view()
    {
        $this->markTestIncomplete();
        $this->withoutExceptionHandling();
        $response = $this->get(route('profile.index'));

        $response->assertOk();
        $response->assertViewIs('home');
    }
}
