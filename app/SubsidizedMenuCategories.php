<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property integer $subsidization_rule_id
 * @property integer $menu_category_id
 * @property int $percent
 * @property string $created_at
 * @property string $updated_at
 * @property MenuCategory $menuCategory
 * @property SubsidizationRule $subsidizationRule
 */
class SubsidizedMenuCategories extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['subsidization_rule_id', 'menu_category_id', 'percent', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsidizationRule()
    {
        return $this->belongsTo('App\SubsidizationRule');
    }
}
