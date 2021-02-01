<?php

namespace Tests;

use App\Company;
use App\Location;
use App\User;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

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
    protected function actingAsAdmin()
    {
        $company = create(Company::class);

        $user = create(User::class, [
            'company_id' => $company->id,
            'role' => User::ROLE_ADMIN
        ]);

        $this->actingAs($user);

        return $user;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function actingAsPosManager()
    {
        $location = create(Location::class);

        $user = create(User::class, [
            'location_id' => $location->id,
            'role' => User::ROLE_POS_MANAGER
        ]);

        $this->actingAs($user);

        return $user;
    }
}
