<?php

namespace Tests\Unit\Models\Consumer\Scope;

use App\Consumer;
use App\LocationGroup;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_consumers()
    {
        create(Consumer::class, [], 5);

        $consumers = Consumer::all();

        $this->assertEquals(5, $consumers->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $consumers);
    }

    /** @test */
    public function it_returns_consumers_that_belongs_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        create(Consumer::class, [
            'location_group_id' => create(LocationGroup::class, [
                'location_id' => $posManager->location_id
            ])
        ], 2);

        create(Consumer::class, [], 3);

        $consumers = Consumer::all();

        $this->assertEquals(2, $consumers->count());
    }
}
