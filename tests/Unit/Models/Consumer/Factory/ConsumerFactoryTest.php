<?php

namespace Tests\Unit\Models\Consumer\Factory;

use App\Consumer;
use Tests\TestCase;

class ConsumerFactoryTest extends TestCase
{
    /** @test */
    public function consumer_factory_persists_one_entity_to_database()
    {
        $consumer = factory(Consumer::class)->create([
            'firstname' => 'New Consumer',
        ]);

        $this->assertDatabaseCount($consumer->getTable(), 1);

        $this->assertDatabaseHas($consumer->getTable(), [
            'firstname' => 'New Consumer',
        ]);
    }

    /** @test */
    public function consumer_factory_persists_many_entities_to_database()
    {
        factory(Consumer::class, 10)->create();

        $this->assertDatabaseCount('companies', 10);
    }
}
