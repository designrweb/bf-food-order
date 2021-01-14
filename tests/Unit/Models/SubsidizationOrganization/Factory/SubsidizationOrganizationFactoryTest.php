<?php

namespace Tests\Unit\Models\SubsidizationOrganization\Factory;

use App\SubsidizationOrganization;
use Tests\TestCase;

/**
 * @group factory
 */
class SubsidizationOrganizationFactoryTest extends TestCase
{
    /** @test */
    public function subsidization_organization_factory_persists_one_entity_to_database()
    {
        $subsidization_organization = create(SubsidizationOrganization::class, [
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
        create(SubsidizationOrganization::class, [], 10);

        $this->assertDatabaseCount('subsidization_organizations', 10);
    }
}
