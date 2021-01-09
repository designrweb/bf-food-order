<?php

namespace Tests\Unit\Models\ConsumerSubsidization\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class ConsumerSubsidizationSchemaTest extends TestCase
{
    /** @test */
    public function consumer_subsidizations_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('consumer_subsidizations', [
                'id',
                'subsidization_rules_id',
                'consumer_id',
                'subsidization_start',
                'subsidization_end',
                'subsidization_document',
                'created_at',
                'updated_at',
                'deleted_at',
            ]), 1);
    }
}
