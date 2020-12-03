<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLocation
 *
 * @package App
 */
class UserLocation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_locations';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'location_id'];
}
