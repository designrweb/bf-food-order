<?php

namespace Tests\Unit\Models\Order\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class OrderSchemaTest extends TestCase
{
    /** @test */
    public function orders_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('orders', [
                'id',
                'type',
                'menuitem_id',
                'consumer_id',
                'day',
                'pickedup',
                'pickedup_at',
                'quantity',
                'is_subsidized',
                'subsidization_organization_id',
                'created_at',
                'updated_at',
                'deleted_at',
            ]), 1);
    }
}
