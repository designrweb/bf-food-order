<?php

namespace Tests\Unit\Models\PaymentDump\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class PaymentDumpSchema extends TestCase
{
    /** @test */
    public function payment_dumps_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('payment_dumps', [
                'id',
                'file_name',
                'status',
                'created_at',
                'updated_at',
                'requested_at',
            ]), 1);
    }
}
