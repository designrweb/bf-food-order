<?php

namespace Tests\Unit\Models\Company\Factory;

use App\Company;
use Tests\TestCase;

class CompanyFactoryTest extends TestCase
{
    /** @test */
    public function company_factory_persists_one_entity_to_database()
    {
        $company = factory(Company::class)->create([
            'name' => 'SallyCompany',
        ]);

        $this->assertDatabaseCount($company->getTable(), 1);

        $this->assertDatabaseHas($company->getTable(), [
            'name' => 'SallyCompany',
        ]);
    }

    /** @test */
    public function company_factory_persists_many_entities_to_database()
    {
        $test = factory(Company::class, 10)->make();

        $this->assertDatabaseCount('companies', 10);
    }
}
