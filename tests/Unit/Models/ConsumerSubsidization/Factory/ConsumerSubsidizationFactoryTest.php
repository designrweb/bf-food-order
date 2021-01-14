<?php

namespace Tests\Unit\Models\ConsumerSubsidization\Factory;

use App\ConsumerSubsidization;
use Tests\TestCase;

/**
 * @group factory
 */
class ConsumerSubsidizationFactoryTest extends TestCase
{
    /** @test */
    public function consumer_subsidization_factory_persists_one_entity_to_database()
    {
        $consumerSubsidization = create(ConsumerSubsidization::class, [
            'subsidization_start' => '2021-05-04',
        ]);

        $this->assertDatabaseCount($consumerSubsidization->getTable(), 1);

        $this->assertDatabaseHas($consumerSubsidization->getTable(), [
            'subsidization_start' => '2021-05-04',
        ]);
    }

    /** @test */
    public function consumer_subsidizations_factory_persists_many_entities_to_database()
    {
        create(ConsumerSubsidization::class, [], 10);

        $this->assertDatabaseCount('consumer_subsidizations', 10);
    }
}
