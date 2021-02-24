<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int     $id
 * @property integer $user_id
 * @property string  $first_name
 * @property string  $last_name
 * @property string  $salutation
 * @property string  $zip
 * @property string  $city
 * @property string  $street
 * @property string  $image_url
 * @property Carbon  $birthday
 * @property mixed   $created_at
 * @property mixed   $updated_at
 * @property User    $user
 */
class UserInfo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_info';

    /**
     * @var array
     */
    protected $fillable = ['user_id', 'first_name', 'last_name', 'salutation', 'zip', 'city', 'street', 'image_url', 'birthday', 'created_at', 'updated_at'];

    protected $dates = [
        'birthday'
    ];

    protected $casts = [
        'birthday' => 'date:d.m.Y',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
