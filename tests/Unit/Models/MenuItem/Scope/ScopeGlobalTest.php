<?php

namespace Tests\Unit\Models\MenuItem\Scope;

use App\Location;
use App\MenuCategory;
use App\MenuItem;
use App\User;
use Tests\TestCase;

/**
 * @group scope
 */
class ScopeGlobalTest extends TestCase
{
    /** @test */
    public function it_returns_all_menu_items()
    {
        create(MenuItem::class, [], 5);

        $menuItems = MenuItem::all();

        $this->assertEquals(5, $menuItems->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $menuItems);
    }

    /** @test */
    public function it_returns_menu_items_that_belongs_to_admin_company()
    {
        $admin = $this->actingAsAdmin();

        create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => create(Location::class, [
                    'company_id' => $admin->company->id
                ])
            ]),
        ], 3);

        create(MenuItem::class, [], 2);

        $menuItems = MenuItem::all();

        $this->assertEquals(3, $menuItems->count());
    }

    /** @test */
    public function it_returns_menu_items_that_belongs_to_pos_manager_location()
    {
        $posManager = create(User::class, [
            'location_id' => create(Location::class),
            'role'        => User::ROLE_POS_MANAGER
        ]);

        create(MenuItem::class, [
            'menu_category_id' => create(MenuCategory::class, [
                'location_id' => $posManager->location_id
            ]),
        ], 2);

        create(MenuItem::class);

        $this->actingAs($posManager);

        $menuItems = MenuItem::all();

        $this->assertEquals(2, $menuItems->count());
    }
}
