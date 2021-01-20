<?php

namespace Tests\Unit\Models\MenuItem\Schema;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * @group schema
 */
class MenuItemSchemaTest extends TestCase
{
    /** @test */
    public function menu_items_database_has_expected_columns()
    {
        $this->assertTrue(
            Schema::hasColumns('menu_items', [
                'id',
                'name',
                'availability_date',
                'description',
                'menu_category_id',
                'imageurl',
                'created_at',
                'updated_at',
            ]), 1);
    }
}
