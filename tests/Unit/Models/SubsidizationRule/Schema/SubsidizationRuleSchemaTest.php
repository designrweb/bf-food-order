<?php

namespace Tests\Unit\Models\SubsidizationRule\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class SubsidizationRuleSchemaTest extends TestCase
{
    /** @test */
    public function subsidization_rules_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('subsidization_rules', [
                'id',
                'rule_name',
                'subsidization_organization_id',
                'start_date',
                'end_date',
                'created_by',
                'created_at',
                'updated_at',
            ]), 1);
    }
}
