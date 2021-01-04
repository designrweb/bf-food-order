<?php

namespace Tests\Unit\Models\Payment\Factory;

use App\Payment;
use Tests\TestCase;

class PaymentFactoryTest extends TestCase
{
    /** @test */
    public function payment_factory_persists_one_entity_to_database()
    {
        $payment = factory(Payment::class)->create([
            'comment' => 'Payment comment',
        ]);

        $this->assertDatabaseCount($payment->getTable(), 1);

        $this->assertDatabaseHas($payment->getTable(), [
            'comment' => 'Payment comment',
        ]);
    }

    /** @test */
    public function payment_factory_persists_many_entities_to_database()
    {
        factory(Payment::class, 10)->create();

        $this->assertDatabaseCount('payments', 10);
    }
}
