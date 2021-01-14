<?php

namespace Tests\Unit\Models\LocationGroup\Factory;

use App\LocationGroup;
use Tests\TestCase;

/**
 * @group factory
 */
class LocationGroupFactoryTest extends TestCase
{
    /** @test */
    public function location_factory_persists_one_entity_to_database()
    {
        $locationGroup = create(LocationGroup::class, [
            'name' => 'New Location Group',
        ]);

        $this->assertDatabaseCount($locationGroup->getTable(), 1);

        $this->assertDatabaseHas($locationGroup->getTable(), [
            'name' => 'New Location Group',
        ]);
    }

    /** @test */
    public function location_factory_persists_many_entities_to_database()
    {
        create(LocationGroup::class, [], 10);

        $this->assertDatabaseCount('location_groups', 10);
    }
}
