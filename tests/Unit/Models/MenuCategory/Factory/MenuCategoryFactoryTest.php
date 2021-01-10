<?php

namespace Tests\Unit\Models\MenuCategory\Factory;

use App\MenuCategory;
use Tests\TestCase;

/**
 * @group factory
 */
class MenuCategoryFactoryTest extends TestCase
{
    /** @test */
    public function menu_category_factory_persists_one_entity_to_database()
    {
        $menuCategory = create(MenuCategory::class, [
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
        create(MenuCategory::class, [], 10);

        $this->assertDatabaseCount('menu_categories', 10);
    }
}
