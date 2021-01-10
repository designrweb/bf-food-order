<?php

namespace Tests\Unit\Models\MenuItem\Factory;

use App\MenuItem;
use Tests\TestCase;

/**
 * @group factory
 */
class MenuItemFactoryTest extends TestCase
{
    /** @test */
    public function menu_item_factory_persists_one_entity_to_database()
    {
        $menuItem = create(MenuItem::class, [
            'name' => 'New MenuItem',
        ]);

        $this->assertDatabaseCount($menuItem->getTable(), 1);

        $this->assertDatabaseHas($menuItem->getTable(), [
            'name' => 'New MenuItem',
        ]);
    }

    /** @test */
    public function menu_item_factory_persists_many_entities_to_database()
    {
        create(MenuItem::class, [], 10);

        $this->assertDatabaseCount('menu_items', 10);
    }
}
