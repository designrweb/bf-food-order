<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int        $id
 * @property string     $name
 * @property string     $zip
 * @property string     $city
 * @property string     $street
 * @property mixed      $created_at
 * @property mixed      $updated_at
 * @property Setting[]  $settings
 * @property Location[] $locations
 */
class Company extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'zip', 'city', 'street', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function settings()
    {
        return $this->hasMany(Setting::class, 'company_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class, 'company_id', 'id');
    }

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !in_array(auth()->user()->role, [User::ROLE_SUPER_ADMIN])) {
                $builder->where('companies.id', auth()->user()->company_id)
                    ->orWhereHas('locations', function ($query) {
                        $query->where('locations.id', auth()->user()->location_id);
                    });
            }
        });
    }

}
