<?php

namespace Tests\Unit\Models\SubsidizationRule\Relation;

use App\SubsidizationRule;
use App\SubsidizedMenuCategories;
use Tests\TestCase;

class SubsidizationRuleRelationTest extends TestCase
{
    /** @test */
    public function subsidization_rule_has_many_subsidized_menu_categories()
    {
        $subsidizationRule   = create(SubsidizationRule::class);

        $subsidizedMenuCategory = create(SubsidizedMenuCategories::class, [
            'subsidization_rule_id' => $subsidizationRule->id
        ]);

        $this->assertTrue($subsidizationRule->subsidizedMenuCategories->contains($subsidizedMenuCategory));
        $this->assertEquals(1, $subsidizationRule->subsidizedMenuCategories->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $subsidizationRule->subsidizedMenuCategories);
    }
}
