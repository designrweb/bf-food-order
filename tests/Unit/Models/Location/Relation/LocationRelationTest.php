<?php

namespace Tests\Unit\Models\Location\Relation;

use App\Company;
use App\Location;
use Tests\TestCase;

class LocationRelationTest extends TestCase
{
    /** @test */
    public function location_belongs_to_company()
    {
        $company = create(Company::class);
        $location    = create(Location::class, [
            'company_id' => $company->id
        ]);

        $this->assertEquals(1, $location->company->count());
        $this->assertInstanceOf(Company::class, $location->company);
    }
}
