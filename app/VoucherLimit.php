<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer      $id
 * @property integer      $menu_category_id
 * @property mixed        $weekday
 * @property int          $percentage
 * @property MenuCategory $menuCategory
 */
class VoucherLimit extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['menu_category_id', 'weekday', 'percentage'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->user()) {
                $builder->whereHas('menuCategory.location', function ($q) {
                    $q->where('locations.company_id', auth()->user()->company_id);
                });
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory');
    }
}
