<?php

namespace Tests\Unit\Models\Location\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class LocationSchemaTest extends TestCase
{
    /** @test */
    public function locations_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('locations', [
                'id',
                'name',
                'street',
                'company_id',
                'zip',
                'city',
                'email',
                'image_name',
            ]), 1);
    }
}
