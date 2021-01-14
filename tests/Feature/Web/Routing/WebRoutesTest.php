<?php

namespace Tests\Feature\Api\Web\Routing;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class WebRoutesTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function it_shows_locations_page()
    {
        $response = $this->get('/admin/locations');

        $response->assertStatus(200);
        $response->assertSee('Locations');
    }

}
