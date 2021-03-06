<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                 $id
 * @property string                  $name
 * @property string                  $start_date
 * @property string                  $end_date
 * @property int                     $created_at
 * @property int                     $updated_at
 * @property VacationLocationGroup[] $locationGroups
 */
class Vacation extends Model
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
    protected $fillable = ['name', 'start_date', 'end_date'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->user() && auth()->user()->role === User::ROLE_SUPER_ADMIN) {
                $builder->whereHas('locationGroups.locationGroup.location', function ($q) {
                    $q->where('locations.company_id', auth()->user()->company_id);
                });
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationGroups()
    {
        return $this->hasMany(VacationLocationGroup::class, 'vacation_id', 'id');
    }

}
