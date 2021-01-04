<?php

namespace Tests\Unit\Models\MenuItem\Factory;

use App\MenuItem;
use Tests\TestCase;

class MenuItemFactoryTest extends TestCase
{
    /** @test */
    public function menu_item_factory_persists_one_entity_to_database()
    {
        $menuItem = factory(MenuItem::class)->create([
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
        factory(MenuItem::class, 10)->create();

        $this->assertDatabaseCount('menu_items', 10);
    }
}
