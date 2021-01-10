<?php

namespace Tests\Unit\Models\SubsidizedMenuCategories\Factory;

use App\SubsidizedMenuCategories;
use Tests\TestCase;

/**
 * @group factory
 */
class SubsidizedMenuCategoriesFactoryTest extends TestCase
{
    /** @test */
    public function subsidized_menu_categories_factory_persists_one_entity_to_database()
    {
        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'percent' => 20,
        ]);

        $this->assertDatabaseCount($subsidizedMenuCategory->getTable(), 1);

        $this->assertDatabaseHas($subsidizedMenuCategory->getTable(), [
            'percent' => 20,
        ]);
    }

    /** @test */
    public function subsidized_menu_categories_factory_persists_many_entities_to_database()
    {
        create(SubsidizedMenuCategories::class, [],  10);

        $this->assertDatabaseCount('subsidized_menu_categories', 10);
    }
}
