<?php

namespace Tests\Feature\Api\Web\Routing;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class AdminPageLinksTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function it_shows_admin_page()
    {
        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertOk();
        $response->assertSee('Admin part');
    }

    // todo add all pages
}
