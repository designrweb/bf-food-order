<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer  $id
 * @property string   $name
 * @property mixed    $category_order
 * @property int      $location_id
 * @property float    $price
 * @property float    $presaleprice
 * @property int      $created_at
 * @property int      $updated_at
 * @property Location $location
 */
class MenuCategory extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var string[]
     */
    protected $appends = ['price_locale', 'presaleprice_locale'];

    /**
     * @var array
     */
    protected $fillable = ['name', 'category_order', 'price', 'presaleprice', 'location_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * @return float|string|string[]
     */
    public function getPriceLocaleAttribute()
    {
        return str_replace('.', ',', $this->price);
    }

    /**
     * @return float|string|string[]
     */
    public function getPresalepriceLocaleAttribute()
    {
        return str_replace('.', ',', $this->presaleprice);
    }

    /**
     * @param $consumer
     * @return bool
     */
    // todo move to repository
    public function isAllowSubsidization($consumer): bool
    {
        return (bool)SubsidizedMenuCategories::where('subsidization_rules_id', $consumer->subsidization->subsidization_rules_id)
            ->where('menu_category_id', $this->id)
            ->where('percent', '>', 0)
            ->count();
    }
}
