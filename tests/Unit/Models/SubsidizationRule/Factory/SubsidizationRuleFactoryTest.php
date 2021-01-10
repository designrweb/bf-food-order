<?php

namespace Tests\Unit\Models\SubsidizationRule\Factory;

use App\SubsidizationRule;
use Tests\TestCase;

/**
 * @group factory
 */
class SubsidizationRuleFactoryTest extends TestCase
{
    /** @test */
    public function subsidization_rule_factory_persists_one_entity_to_database()
    {
        $subsidization_rule = create(SubsidizationRule::class, [
            'rule_name' => 'New Subsidization Rule',
        ]);

        $this->assertDatabaseCount($subsidization_rule->getTable(), 1);

        $this->assertDatabaseHas($subsidization_rule->getTable(), [
            'rule_name' => 'New Subsidization Rule',
        ]);
    }

    /** @test */
    public function subsidization_rule_factory_persists_many_entities_to_database()
    {
        create(SubsidizationRule::class, [], 10);

        $this->assertDatabaseCount('subsidization_rules', 10);
    }
}
