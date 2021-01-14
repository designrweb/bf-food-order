<?php

namespace Tests\Unit\Models\LocationGroup\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class LocationGroupSchemaTest extends TestCase
{
    /** @test */
    public function location_groups_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('location_groups', [
                'id',
                'location_id',
                'name',
            ]), 1);
    }
}
