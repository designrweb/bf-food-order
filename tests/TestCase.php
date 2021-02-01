<?php

namespace Tests;

use App\Company;
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

    protected function actingAsAdmin()
    {
        $company = create(Company::class);

        $user = create(User::class, [
            'company_id' => $company->id
        ]);

        $this->actingAs($user);

        return $user;
    }
}
