<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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
 * @property int      $not_available_for_pos
 * @property Location $location
 */
class MenuCategory extends Model
{

    const AVAILABLE_POS     = 0;
    const NOT_AVAILABLE_POS = 1;

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
    protected $fillable = ['name', 'category_order', 'price', 'presaleprice', 'not_available_for_pos', 'location_id', 'created_at', 'updated_at'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id);
                });
            }
        });
    }

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
     * @param $value
     */
    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * @param $value
     */
    public function setUpdatedAtAttribute($value)
    {
        $this->attributes['updated_at'] = date('Y-m-d H:i:s', strtotime($value));
    }

    /**
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '.', $value);
    }

    /**
     * @param $value
     */
    public function setPresalepriceAttribute($value)
    {
        $this->attributes['presaleprice'] = str_replace(',', '.', $value);
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
