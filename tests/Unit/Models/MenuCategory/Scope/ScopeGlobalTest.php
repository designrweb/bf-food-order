<?php

namespace Tests\Unit\Models\MenuCategory\Scope;

use App\Location;
use App\MenuCategory;
use App\User;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_menu_categories()
    {
        create(MenuCategory::class, [], 5);

        $menuCategories = MenuCategory::all();

        $this->assertEquals(5, $menuCategories->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $menuCategories);
    }

    /** @test */
    public function it_returns_menu_categories_that_belongs_to_admin_company()
    {
        $admin = $this->actingAsAdmin();

        create(MenuCategory::class, [
            'location_id' => create(Location::class, [
                'company_id' => $admin->company->id
            ])
        ], 3);

        create(MenuCategory::class, [], 2);

        $menuCategories = MenuCategory::all();

        $this->assertEquals(3, $menuCategories->count());
    }

    /** @test */
    public function it_returns_menu_categories_that_belongs_to_pos_manager_location()
    {
        $posManager = create(User::class, [
            'location_id' => create(Location::class),
            'role'       => User::ROLE_POS_MANAGER
        ]);

        create(MenuCategory::class, [
            'location_id' => $posManager->location_id
        ], 2);

        create(MenuCategory::class, [], 3);

        $this->actingAs($posManager);

        $menuCategories = MenuCategory::all();

        $this->assertEquals(2, $menuCategories->count());
    }
}
