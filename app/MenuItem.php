<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer      $id
 * @property integer      $menu_category_id
 * @property string       $name
 * @property string       $availability_date
 * @property string       $description
 * @property string       $imageurl
 * @property mixed        $created_at
 * @property mixed        $updated_at
 * @property MenuCategory $menuCategory
 */
class MenuItem extends Model
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
    protected $appends = ['availability_date_human'];

    /**
     * @var array
     */
    protected $fillable = ['menu_category_id', 'name', 'availability_date', 'description', 'imageurl', 'created_at', 'updated_at'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('menuCategory.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id)
                        ->orWhere('menu_categories.location_id', auth()->user()->location_id);
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

    /**
     * @return false|string
     */
    public function getAvailabilityDateHumanAttribute()
    {
        return date('l, d.m.Y', strtotime($this->attributes['availability_date']));
    }

    /**
     * @param $value
     */
    public function setAvailabilityDateAttribute($value)
    {
        $this->attributes['availability_date'] = date('Y-m-d', strtotime($value));
    }

    /**
     * Count picked up menu orders for current day
     *
     * @return mixed
     */
    public function getCountPickedItemsAttribute()
    {
        $pickedOrders = $this->hasMany(Order::class, 'menuitem_id', 'id')
            ->where('type', Order::TYPE_PRE_ORDER)
            ->where('pickedup', 1)
            ->where('day', date('Y-m-d'))
            ->get()
            ->toArray();;

        return array_reduce($pickedOrders, function (&$res, $item) {
            return $res + $item['quantity'];
        }, 0);
    }

    /**
     * Count preordered menus for current day
     *
     * @return mixed
     */
    public function getCountPreOrderedItemsAttribute()
    {
        $preOrders = $this->hasMany(Order::class, 'menuitem_id', 'id')
            ->where('type', Order::TYPE_PRE_ORDER)
            ->where('day', date('Y-m-d'))
            ->get()
            ->toArray();

        return array_reduce($preOrders, function (&$res, $item) {
            return $res + $item['quantity'];
        }, 0);
    }

    /**
     * Count picked up spontaneous orders
     *
     * @return mixed
     */
    public function getCountSpontaneousItemsAttribute()
    {
        $spontaneousOrders = $this->hasMany(Order::class, 'menuitem_id', 'id')
            ->where('pickedup', 1)
            ->where('type', '!=', Order::TYPE_PRE_ORDER)
            ->get()
            ->toArray();

        return array_reduce($spontaneousOrders, function (&$res, $item) {
            return $res + $item['quantity'];
        }, 0);
    }
}
