<?php

namespace Tests\Unit\Models\Location\Factory;

use App\Location;
use Tests\TestCase;

class LocationFactoryTest extends TestCase
{
    /** @test */
    public function location_factory_persists_one_entity_to_database()
    {
        $location = factory(Location::class)->create([
            'name' => 'New Location',
        ]);

        $this->assertDatabaseCount($location->getTable(), 1);

        $this->assertDatabaseHas($location->getTable(), [
            'name' => 'New Location',
        ]);
    }

    /** @test */
    public function location_factory_persists_many_entities_to_database()
    {
        factory(Location::class, 10)->create();

        $this->assertDatabaseCount('locations', 10);
    }
}
