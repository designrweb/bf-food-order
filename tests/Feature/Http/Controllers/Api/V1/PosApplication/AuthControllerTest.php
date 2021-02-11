<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\Location;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @group pos_api_controller
 */
class AuthControllerTest extends TestCase
{
    /** @test */
    public function it_login_pos_manager_and_return_token()
    {
        create(User::class, [
            'email'       => 'pos@examle.com',
            'password'    => Hash::make('posmanager'),
            'role'        => User::ROLE_POS_MANAGER,
            'location_id' => create(Location::class),
        ]);

        $response = $this->postJson('/api/v1/pos/user/login', [
            'login'    => 'pos@examle.com',
            'password' => 'posmanager'
        ]);
        $response
            ->assertOk()
            ->assertJsonStructure([
                'username', 'auth_key'
            ]);
    }

    /** @test */
    public function it_not_login_pos_manager_wit_wrong_credentials()
    {
        create(User::class, [
            'email'       => 'pos@examle.com',
            'password'    => Hash::make('posmanager'),
            'role'        => User::ROLE_POS_MANAGER,
            'location_id' => create(Location::class),
        ]);

        $response = $this->postJson('/api/v1/pos/user/login', [
            'email'    => 'other@email.com',
            'password' => 'wrong-pass'
        ]);
        $response
            ->assertStatus(422)
            ->assertExactJson([
                "errors" => [
                    "password" => "Invalid login or password"
                ]
            ]);
    }

    /** @test */
    public function it_logout_pos_manager()
    {
        $this->actingAsPosManager();

        $response = $this->postJson('/api/v1/pos/logout');

        $response
            ->assertOk()
            ->assertExactJson([
                'message' => 'Successfully logged out'
            ]);
    }

    /** @test */
    public function it_returns_logged_pos_manager()
    {
        $this->actingAsPosManager();

        $response = $this->getJson('/api/v1/pos/user/data');

        $response
            ->assertOk()
            ->assertJsonStructure([
                'username', 'auth_key'
            ]);
    }
}
