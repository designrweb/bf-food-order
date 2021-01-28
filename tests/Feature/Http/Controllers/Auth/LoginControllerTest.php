<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @group controller
 */
class LoginControllerTest extends TestCase
{
    /** @test */
    public function login_displays_the_login_form()
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('auth.login');
    }

    /** @test */
    public function login_displays_validation_errors()
    {
        $response = $this->post(route('login'), []);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function login_authenticates_and_redirects_user()
    {
        $user = create(User::class, [
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin')
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'admin'
        ]);

        $response->assertRedirect(route('profile.index'));
        $this->assertAuthenticatedAs($user);
    }
}
