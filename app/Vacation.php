<?php

namespace App;

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
    protected $fillable = ['name', 'start_date', 'end_date', 'created_at', 'updated_at'];


    public function locationGroups()
    {
        // return $this->hasManyThrough(LocationGroup::class, VacationLocationGroup::class, 'vacation_id', 'id', 'id', 'location_group_id');
        return $this->hasMany(VacationLocationGroup::class, 'vacation_id', 'id');
    }

}
