<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer  $id
 * @property integer  $location_id
 * @property string   $name
 * @property Consumer $consumers
 * @property Location $location
 */
class LocationGroup extends Model
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
    protected $fillable = ['location_id', 'name'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumers()
    {
        return $this->hasMany(Consumer::class, 'location_group_id', 'id');
    }
}
