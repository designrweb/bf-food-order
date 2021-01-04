<?php

namespace Tests\Unit\Models\MenuCategory\Factory;

use App\MenuCategory;
use Tests\TestCase;

class MenuCategoryFactoryTest extends TestCase
{
    /** @test */
    public function menu_category_factory_persists_one_entity_to_database()
    {
        $menuCategory = factory(MenuCategory::class)->create([
            'name' => 'New Menu Category',
        ]);

        $this->assertDatabaseCount($menuCategory->getTable(), 1);

        $this->assertDatabaseHas($menuCategory->getTable(), [
            'name' => 'New Menu Category',
        ]);
    }

    /** @test */
    public function menu_category_factory_persists_many_entities_to_database()
    {
        factory(MenuCategory::class, 10)->create();

        $this->assertDatabaseCount('menu_categories', 10);
    }
}
