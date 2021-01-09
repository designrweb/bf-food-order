<?php

namespace Tests\Unit\Models\Company\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class CompanySchemaTest extends TestCase
{
    /** @test */
    public function companies_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('companies', [
                'id',
                'name',
                'zip',
                'city',
                'street',
                'created_at',
                'updated_at',
            ]), 1);
    }
}
