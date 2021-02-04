<?php

namespace Tests\Unit\Models\LocationGroup\Scope;

use App\LocationGroup;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_location_groups()
    {
        create(LocationGroup::class, [], 5);

        $locationGroup = LocationGroup::all();

        $this->assertEquals(5, $locationGroup->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $locationGroup);
    }

    /** @test */
    public function it_returns_location_groups_that_belongs_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        create(LocationGroup::class, [
            'location_id' => $posManager->location_id
        ], 2);

        create(LocationGroup::class, [], 3);

        $locationGroup = LocationGroup::all();

        $this->assertEquals(2, $locationGroup->count());
    }
}
