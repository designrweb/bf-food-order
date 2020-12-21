<?php

namespace App;

use App\Components\ImageComponent;
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
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var string[]
     */
    protected $appends = ['full_name'];

    /**
     * @var array
     */
    protected $fillable = ['location_group_id', 'user_id', 'account_id', 'firstname', 'lastname', 'birthday', 'imageurl', 'balance', 'balance_limit', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationgroup()
    {
        return $this->belongsTo('App\LocationGroup', 'location_group_id', 'id');
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
        if (!empty($value)) {
            return ImageComponent::decrypt($value);
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function qrcode()
    {
        return $this->hasOne(ConsumerQrCode::class, 'consumer_id', 'id');
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
