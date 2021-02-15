<?php

namespace Tests\Unit\Models\SubsidizedMenuCategories\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class SubsidizedMenuCategoriesSchemaTest extends TestCase
{
    /** @test */
    public function subsidized_menu_categories_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('subsidized_menu_categories', [
                'id',
                'subsidization_rule_id',
                'menu_category_id',
                'percent',
                'created_at',
                'updated_at',
            ]), 1);
    }
}
