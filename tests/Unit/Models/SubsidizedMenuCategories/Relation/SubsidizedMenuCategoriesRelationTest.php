<?php

namespace Tests\Unit\Models\SubsidizedMenuCategories\Relation;

use App\Company;
use App\Location;
use App\MenuCategory;
use App\SubsidizationOrganization;
use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Tests\TestCase;

/**
 * @group relation
 */
class SubsidizedMenuCategoriesRelationTest extends TestCase
{
    /** @test */
    public function subsidized_menu_category_belongs_to_subsidization_rule()
    {
        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => create(SubsidizationRule::class)
        ]);

        $this->assertEquals(1, $subsidizedMenuCategory->subsidizationRule->count());
        $this->assertInstanceOf(SubsidizationRule::class, $subsidizedMenuCategory->subsidizationRule);
    }

    /** @test */
    public function subsidization_rule_relation_returns_subsidized_menu_category_that_belongs_to_admin_company()
    {
        $admin = $this->actingAsAdmin();

        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => create(SubsidizationRule::class, [
                'subsidization_organization_id' => create(SubsidizationOrganization::class, [
                    'company_id' => $admin->company->id,
                ]),
            ]),
            'menu_category_id'       => create(MenuCategory::class),
        ]);

        $this->assertEquals(1, $subsidizedMenuCategory->subsidizationRule->count());
        $this->assertInstanceOf(SubsidizationRule::class, $subsidizedMenuCategory->subsidizationRule);
    }

    /** @test */
    public function subsidization_rule_relation_returns_subsidized_menu_category_that_belongs_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => create(SubsidizationRule::class, [
                'subsidization_organization_id' => create(SubsidizationOrganization::class, [
//                    'company_id' => $posManager->location->company->id,
                    'company_id' => create(Company::class),
                ]),
            ]),
            'menu_category_id'       => create(MenuCategory::class, [
//                'location_id' => $posManager->location->id,
                'location_id' => create(Location::class, [
                    'company_id' => $posManager->location->company->id,
                ])
            ]),
        ]);

        $this->assertEquals(1, $subsidizedMenuCategory->subsidizationRule->count());
        $this->assertInstanceOf(SubsidizationRule::class, $subsidizedMenuCategory->subsidizationRule);
    }
}
