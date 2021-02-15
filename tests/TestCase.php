<?php

namespace Tests;

use App\Company;
use App\Location;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function actingAsAdmin(): \Illuminate\Database\Eloquent\Model
    {
        $company = create(Company::class);

        $user = create(User::class, [
            'company_id' => $company->id,
            'role'       => User::ROLE_ADMIN
        ]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function actingAsPosManager(): \Illuminate\Database\Eloquent\Model
    {
        $user = create(User::class, [
            'email'       => 'pos@manager.com',
            'password'    => Hash::make('secret'),
            'role'        => User::ROLE_POS_MANAGER,
            'location_id' => create(Location::class),
        ]);

        $token = JWTAuth::fromUser($user);

        $this->withHeader('Authorization', "Bearer {$token}");

//        $this->actingAs($user);

        return $user;
    }
}
