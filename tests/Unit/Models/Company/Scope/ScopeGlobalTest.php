<?php

namespace Tests\Unit\Models\Company\Scope;

use App\Company;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_companies()
    {
        create(Company::class, [], 5);

        $companies = Company::all();

        $this->assertEquals(5, $companies->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $companies);
    }

    /** @test */
    public function it_returns_companies_that_has_current_admin()
    {
        $this->actingAsAdmin();

        create(Company::class, [], 2);

        $companies = Company::all();

        $this->assertEquals(1, $companies->count());
    }

    /** @test */
    public function it_returns_companies_that_has_current_pos_manager()
    {
        $this->actingAsPosManager();

        create(Company::class, [], 3);

        $companies = Company::all();

        $this->assertEquals(1, $companies->count());
    }
}
