<?php

namespace Tests\Feature\Http\Controllers\Api\V1\PosApplication;

use App\Location;
use App\MenuCategory;
use App\MenuItem;
use Carbon\Carbon;
use Tests\TestCase;

class MenuItemControllerTest extends TestCase
{
    /** @test */
    public function it_returns_all_menu_items()
    {
        $menuCategoryOne = create(MenuCategory::class, [
            'price' => 4.55
        ]);
        $menuCategoryTwo = create(MenuCategory::class, [
            'price' => 3.66
        ]);

        $menuItemFirst = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryOne->id,
        ]);

        $menuItemSecond = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryTwo->id,
        ]);

        $response = $this->get('/api/v1/pos/menuitem');

        $response->assertOk();
        $response->assertExactJson([
            [
                'menuitem_id'           => $menuItemFirst->id,
                "categoryId"            => $menuCategoryOne->id,
                "categoryName"          => $menuCategoryOne->name,
                "name"                  => $menuItemFirst->name,
                "price"                 => $menuCategoryOne->price,
                "description"           => $menuItemFirst->description,
                "availability_date"     => $menuItemFirst->availability_date,
                "countPickedItems"      => $menuItemFirst->count_picked_items,
                "countPreOrderedItems"  => $menuItemFirst->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemFirst->count_spontaneous_items
            ],
            [
                'menuitem_id'           => $menuItemSecond->id,
                "categoryId"            => $menuCategoryTwo->id,
                "categoryName"          => $menuCategoryTwo->name,
                "name"                  => $menuItemSecond->name,
                "price"                 => $menuCategoryTwo->price,
                "description"           => $menuItemSecond->description,
                "availability_date"     => $menuItemSecond->availability_date,
                "countPickedItems"      => $menuItemSecond->count_picked_items,
                "countPreOrderedItems"  => $menuItemSecond->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemSecond->count_spontaneous_items
            ]
        ]);
    }

    /** @test */
    public function it_returns_menu_items_available_for_today()
    {
        $menuCategoryOne = create(MenuCategory::class, [
            'price' => 4.55
        ]);
        $menuCategoryTwo = create(MenuCategory::class, [
            'price' => 3.66
        ]);

        $menuItemFirst = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryOne->id,
        ]);

        $menuItemSecond = create(MenuItem::class, [
            'availability_date' => Carbon::now()->addDays(2),
            'menu_category_id'  => $menuCategoryTwo->id,
        ]);

        $response = $this->get('/api/v1/pos/menuitem');

        $response->assertOk();
        $response->assertExactJson([
            [
                'menuitem_id'           => $menuItemFirst->id,
                "categoryId"            => $menuCategoryOne->id,
                "categoryName"          => $menuCategoryOne->name,
                "name"                  => $menuItemFirst->name,
                "price"                 => $menuCategoryOne->price,
                "description"           => $menuItemFirst->description,
                "availability_date"     => $menuItemFirst->availability_date,
                "countPickedItems"      => $menuItemFirst->count_picked_items,
                "countPreOrderedItems"  => $menuItemFirst->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemFirst->count_spontaneous_items
            ],
        ]);

        $response->assertJsonMissingExact(
            [
                'menuitem_id'           => $menuItemSecond->id,
                "categoryId"            => $menuCategoryTwo->id,
                "categoryName"          => $menuCategoryTwo->name,
                "name"                  => $menuItemSecond->name,
                "price"                 => $menuCategoryTwo->price,
                "description"           => $menuItemSecond->description,
                "availability_date"     => $menuItemSecond->availability_date,
                "countPickedItems"      => $menuItemSecond->count_picked_items,
                "countPreOrderedItems"  => $menuItemSecond->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemSecond->count_spontaneous_items
            ]
        );
    }

    /** @test */
    public function it_returns_menu_items_with_price_more_than_zero()
    {
        $menuCategoryOne = create(MenuCategory::class, [
            'price' => 4.55
        ]);
        $menuCategoryTwo = create(MenuCategory::class, [
            'price' => 0
        ]);

        $menuItemFirst = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryOne->id,
        ]);

        $menuItemSecond = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryTwo->id,
        ]);

        $response = $this->get('/api/v1/pos/menuitem');

        $response->assertOk();
        $response->assertExactJson([
            [
                'menuitem_id'           => $menuItemFirst->id,
                "categoryId"            => $menuCategoryOne->id,
                "categoryName"          => $menuCategoryOne->name,
                "name"                  => $menuItemFirst->name,
                "price"                 => $menuCategoryOne->price,
                "description"           => $menuItemFirst->description,
                "availability_date"     => $menuItemFirst->availability_date,
                "countPickedItems"      => $menuItemFirst->count_picked_items,
                "countPreOrderedItems"  => $menuItemFirst->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemFirst->count_spontaneous_items
            ],
        ]);

        $response->assertJsonMissingExact(
            [
                'menuitem_id'           => $menuItemSecond->id,
                "categoryId"            => $menuCategoryTwo->id,
                "categoryName"          => $menuCategoryTwo->name,
                "name"                  => $menuItemSecond->name,
                "price"                 => $menuCategoryTwo->price,
                "description"           => $menuItemSecond->description,
                "availability_date"     => $menuItemSecond->availability_date,
                "countPickedItems"      => $menuItemSecond->count_picked_items,
                "countPreOrderedItems"  => $menuItemSecond->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemSecond->count_spontaneous_items
            ]
        );
    }

    /** @test */
    public function it_returns_menu_items_that_belong_to_pos_manager_location()
    {
        $posManager = $this->actingAsPosManager();

        $otherLocation = create(Location::class);

        $menuCategoryOne = create(MenuCategory::class, [
            'price'       => 4.55,
            'location_id' => $posManager->location_id
        ]);
        $menuCategoryTwo = create(MenuCategory::class, [
            'price'       => 3.66,
            'location_id' => $otherLocation->id
        ]);

        $menuItemFirst = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryOne->id,
        ]);

        $menuItemSecond = create(MenuItem::class, [
            'availability_date' => Carbon::now(),
            'menu_category_id'  => $menuCategoryTwo->id,
        ]);

        $response = $this->get('/api/v1/pos/menuitem');

        $response->assertOk();
        $response->assertExactJson([
            [
                'menuitem_id'           => $menuItemFirst->id,
                "categoryId"            => $menuCategoryOne->id,
                "categoryName"          => $menuCategoryOne->name,
                "name"                  => $menuItemFirst->name,
                "price"                 => $menuCategoryOne->price,
                "description"           => $menuItemFirst->description,
                "availability_date"     => $menuItemFirst->availability_date,
                "countPickedItems"      => $menuItemFirst->count_picked_items,
                "countPreOrderedItems"  => $menuItemFirst->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemFirst->count_spontaneous_items
            ],
        ]);

        $response->assertJsonMissingExact(
            [
                'menuitem_id'           => $menuItemSecond->id,
                "categoryId"            => $menuCategoryTwo->id,
                "categoryName"          => $menuCategoryTwo->name,
                "name"                  => $menuItemSecond->name,
                "price"                 => $menuCategoryTwo->price,
                "description"           => $menuItemSecond->description,
                "availability_date"     => $menuItemSecond->availability_date,
                "countPickedItems"      => $menuItemSecond->count_picked_items,
                "countPreOrderedItems"  => $menuItemSecond->count_pre_ordered_items,
                "countSpontaneousItems" => $menuItemSecond->count_spontaneous_items
            ]
        );
    }
}
