<?php

namespace Tests\Unit\Models\MenuCategory;

use App\Consumer;
use App\ConsumerSubsidization;
use App\MenuCategory;
use App\MenuItem;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Tests\TestCase;

class MenuCategoryTest extends TestCase
{
    /** @test */
    public function menu_category_can_be_subsidized()
    {
        // we  have menu category with menu item
        $menuCategory = create(MenuCategory::class);
        create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);
        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rules_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 50,
        ]);

        $canBeSubsidized = $menuCategory->isAllowSubsidization($consumer);

        $this->assertTrue($canBeSubsidized);
    }

    /** @test */
    public function menu_category_can_not_be_subsidized()
    {
        // we  have menu category with menu item
        $menuCategory = create(MenuCategory::class);
        create(MenuItem::class, [
            'menu_category_id' => $menuCategory->id,
        ]);

        // we have consumer with subsidization
        $consumer          = create(Consumer::class);
        $subsidizationRule = create(SubsidizationRule::class, [
            'start_date' => null,
            'end_date'   => null,
        ]);
        create(ConsumerSubsidization::class, [
            'consumer_id'            => $consumer->id,
            'subsidization_rules_id' => $subsidizationRule->id,
            'subsidization_start'    => null,
            'subsidization_end'      => null,
        ]);

        // we have subsidized menu category
        create(SubsidizedMenuCategories::class, [
            'subsidization_rules_id' => $subsidizationRule->id,
            'menu_category_id'       => $menuCategory->id,
            'percent'                => 0,
        ]);

        $canBeSubsidized = $menuCategory->isAllowSubsidization($consumer);

        $this->assertFalse($canBeSubsidized);
    }
}
