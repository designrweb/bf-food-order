<?php

namespace Tests\Unit\Models\Location\Scope;

use App\Location;
use App\User;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_locations()
    {
        create(Location::class, [], 5);

        $this->assertDatabaseCount('locations', 5);

        $locations = Location::all();

        $this->assertEquals(5, $locations->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $locations);
    }

    /** @test */
    public function it_returns_locations_that_has_current_admin()
    {
        $admin = $this->actingAsAdmin();

        create(Location::class, [
            'company_id' => $admin->company_id
        ]);

        create(Location::class, [], 2);

        $locations = Location::all();

        $this->assertEquals(1, $locations->count());
    }

    /** @test */
    public function it_returns_locations_that_has_current_pos_manager()
    {
        $posManager = create(User::class, [
            'location_id' => create(Location::class),
            'role'       => User::ROLE_POS_MANAGER
        ]);

        create(Location::class, [], 3);

        $this->actingAs($posManager);

        $locations = Location::all();

        $this->assertEquals(1, $locations->count());
    }
}
