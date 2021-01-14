<?php

namespace Tests\Unit\Models\Consumer\Relation;

use App\Consumer;
use App\ConsumerSubsidization;
use App\SubsidizationRule;
use Tests\TestCase;

/**
 * @group relation
 */
class ConsumerRelationTest extends TestCase
{
    /** @test */
    public function consumer_has_subsidization()
    {
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class);

        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id
        ]);

        $this->assertEquals(1, $consumer->subsidization->count());
        $this->assertInstanceOf(ConsumerSubsidization::class, $consumer->subsidization);
    }

    /** @test */
    public function consumer_does_not_have_direct_subsidization_rule_relation()
    {
        $consumer = create(Consumer::class);

        $this->assertEmpty($consumer->subsidizationRule);
    }
}
