<?php

namespace Tests\Unit\Models\Consumer\Factory;

use App\Consumer;
use Tests\TestCase;

/**
 * @group factory
 */
class ConsumerFactoryTest extends TestCase
{
    /** @test */
    public function consumer_factory_persists_one_entity_to_database()
    {
        $consumer = create(Consumer::class, [
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
        $consumers = create(Consumer::class, [], 10);

        $this->assertDatabaseCount('consumers', 10);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $consumers);
    }
}
