<?php

namespace Tests\Unit\Models\Payment\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class PaymentSchemaTest extends TestCase
{
    /** @test */
    public function payments_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('payments', [
                'id',
                'amount',
                'type',
                'comment',
                'order_id',
                'consumer_id',
                'created_at',
                'updated_at',
                'transacted_at',
            ]), 1);
    }
}
