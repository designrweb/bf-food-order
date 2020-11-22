<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer       $id
 * @property integer       $location_group_id
 * @property integer       $user_id
 * @property string        $account_id
 * @property string        $firstname
 * @property string        $lastname
 * @property string        $birthday
 * @property string        $imageurl
 * @property float         $balance
 * @property int           $balance_limit
 * @property string        $created_at
 * @property string        $updated_at
 * @property string        $deleted_at
 * @property LocationGroup $locationGroup
 * @property User          $user
 */
class Consumer extends Model
{
    const IS_BASE64 = true;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['location_group_id', 'user_id', 'account_id', 'firstname', 'lastname', 'birthday', 'imageurl', 'balance', 'balance_limit', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationGroup()
    {
        return $this->belongsTo('App\LocationGroup');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageurlAttribute($value)
    {
        if (self::IS_BASE64 && !empty($value)) {
            return $value;
        } elseif (!self::IS_BASE64 && !empty($value)) {
            return asset('consumer/' . $value);
        }

        return null;
    }

    /**
     * @param $value
     */
    public function setImageurlAttribute($value)
    {
        if (!self::IS_BASE64) {
            $this->attributes['imageurl'] = str_replace(asset('consumer') . '/', '', $value);
        } else {
            $this->attributes['imageurl'] = $value;
        }
    }
}
