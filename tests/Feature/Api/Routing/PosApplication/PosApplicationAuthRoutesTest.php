<?php

namespace Tests\Feature\Api\Api\Routing\PosApplication;

use Tests\TestCase;

class PosApplicationAuthRoutesTest extends TestCase
{
    /** @test */
    public function itResponsesOnUserLogin()
    {
        $response = $this->post('/api/v1/pos/user/login');

//        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnUserLogout()
    {
        $response = $this->post('/api/v1/pos/user/logout');

//        $response->assertStatus(200);
    }

    /** @test */
    public function itResponsesOnUserData()
    {
        $response = $this->get('/api/v1/pos/user/data');

//        $response->assertStatus(200);
    }
}
