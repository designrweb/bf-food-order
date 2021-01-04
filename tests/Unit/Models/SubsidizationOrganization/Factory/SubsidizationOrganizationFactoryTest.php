<?php

namespace Tests\Unit\Models\SubsidizationOrganization\Factory;

use App\SubsidizationOrganization;
use Tests\TestCase;

class SubsidizationOrganizationFactoryTest extends TestCase
{
    /** @test */
    public function subsidization_organization_factory_persists_one_entity_to_database()
    {
        $subsidization_organization = factory(SubsidizationOrganization::class)->create([
            'name' => 'New Subsidization Organization',
        ]);

        $this->assertDatabaseCount($subsidization_organization->getTable(), 1);

        $this->assertDatabaseHas($subsidization_organization->getTable(), [
            'name' => 'New Subsidization Organization',
        ]);
    }

    /** @test */
    public function subsidization_organization_factory_persists_many_entities_to_database()
    {
        factory(SubsidizationOrganization::class, 10)->create();

        $this->assertDatabaseCount('subsidization_organizations', 10);
    }
}
