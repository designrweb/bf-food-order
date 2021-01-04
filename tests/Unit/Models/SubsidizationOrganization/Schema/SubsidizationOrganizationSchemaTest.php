<?php

namespace Tests\Unit\Models\SubsidizationOrganization\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class SubsidizationOrganizationSchemaTest extends TestCase
{
    /** @test */
    public function subsidization_organizations_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('subsidization_organizations', [
                'id',
                'name',
                'zip',
                'city',
                'street',
                'company_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]), 1);
    }
}
