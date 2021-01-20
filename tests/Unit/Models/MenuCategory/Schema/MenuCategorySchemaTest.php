<?php

namespace Tests\Unit\Models\MenuCategory\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class MenuCategorySchemaTest extends TestCase
{
    /** @test */
    public function menu_categories_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('menu_categories', [
                'id',
                'name',
                'category_order',
                'price',
                'presaleprice',
                'location_id',
                'created_at',
                'updated_at',
            ]), 1);
    }
}
