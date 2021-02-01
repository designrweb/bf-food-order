<?php

namespace Tests\Unit\Models\User\Relation;

use App\Company;
use App\Location;
use App\User;
use Tests\TestCase;

/**
 * @group relation
 */
class UserRelationTest extends TestCase
{
    /** @test */
    public function user_belongs_to_location()
    {
        $location = create(Location::class);
        $user     = create(User::class, [
            'location_id' => $location->id
        ]);

        $this->assertEquals(1, $user->location->count());
        $this->assertInstanceOf(Location::class, $user->location);
    }

    /** @test */
    public function user_belongs_to_company()
    {
        $company = create(Company::class);
        $user    = create(User::class, [
            'company_id' => $company->id
        ]);

        $this->assertEquals(1, $user->company->count());
        $this->assertInstanceOf(Company::class, $user->company);
    }
}
