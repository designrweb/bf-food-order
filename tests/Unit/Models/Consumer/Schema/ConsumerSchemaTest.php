<?php

namespace Tests\Unit\Models\Consumer\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class ConsumerSchemaTest extends TestCase
{
    /** @test */
    public function consumers_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('consumers', [
                'id',
                'account_id',
                'firstname',
                'lastname',
                'birthday',
                'imageurl',
                'balance',
                'balance_limit',
                'location_group_id',
                'user_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]), 1);
    }
}
