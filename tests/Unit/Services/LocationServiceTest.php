<?php

namespace Tests\Unit\Services;

use App\Location;
use App\MenuCategory;
use App\Services\LocationService;
use Exception;
use Tests\TestCase;

class LocationServiceTest extends TestCase
{
    protected $locationService;

    public function setUp(): void
    {
        parent::setUp();
        $this->locationService = $this->app->make(LocationService::class);
    }

    /** @test */
    public function location_can_be_deleted_if_not_has_related_data()
    {
        $location = create(Location::class);

        $this->assertDatabaseHas('locations', [
            'id' => $location->id,
        ]);

        $this->locationService->remove($location->id);

        $this->assertDatabaseMissing('locations', [
            'id' => $location->id,
        ]);
    }

    /** @test */
    public function location_can_not_be_deleted_if_has_related_data()
    {
        $location = create(Location::class);

        // related data
        create(MenuCategory::class, [
            'location_id' => $location->id
        ]);

        $this->expectException(Exception::class);

        $this->locationService->remove($location->id);
    }
}
