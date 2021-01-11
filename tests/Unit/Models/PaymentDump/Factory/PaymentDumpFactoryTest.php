<?php

namespace Tests\Unit\Models\PaymentDump\Factory;

use App\PaymentDump;
use Tests\TestCase;

/**
 * @group factory
 */
class PaymentDumpFactoryTest extends TestCase
{
    /** @test */
    public function payment_dump_factory_persists_one_entity_to_database()
    {
        $paymentDump = create(PaymentDump::class, [
            'file_name' => 'dump-file.csv',
        ]);

        $this->assertDatabaseCount($paymentDump->getTable(), 1);

        $this->assertDatabaseHas($paymentDump->getTable(), [
            'file_name' => 'dump-file.csv',
        ]);
    }

    /** @test */
    public function payment_dump_factory_persists_many_entities_to_database()
    {
        create(PaymentDump::class, [], 10);

        $this->assertDatabaseCount('payment_dumps', 10);
    }
}
