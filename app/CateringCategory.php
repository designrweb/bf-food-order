<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer        $id
 * @property integer        $location_id
 * @property string         $name
 * @property mixed          $created_at
 * @property mixed          $updated_at
 * @property Location       $location
 * @property CateringItem[] $cateringItems
 */
class CateringCategory extends Model
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
    protected $fillable = ['location_id', 'name', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['created_at_human', 'updated_at_human'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== User::ROLE_USER) {
                $builder->whereHas('location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id)
                        ->orWhere('locations.id', auth()->user()->location_id);
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cateringItems()
    {
        return $this->hasMany('App\CateringItem');
    }

    /**
     * @return false|string
     */
    public function getCreatedAtHumanAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('l, d.m.Y');
    }

    /**
     * @return false|string
     */
    public function getUpdatedAtHumanAttribute()
    {
        return Carbon::parse($this->updated_at)->translatedFormat('l, d.m.Y');
    }
}
