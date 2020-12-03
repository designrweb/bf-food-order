<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 *
 * @property integer  $id
 * @property string   $name
 * @property string   $email
 * @property string   $email_verified_at
 * @property string   $password
 * @property string   $remember_token
 * @property string   $created_at
 * @property string   $updated_at
 * @property string   $deleted_at
 * @property string   $role
 * @property UserInfo $userInfo
 * @property Consumer $consumers
 * @property Location $location
 *
 * @package App
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;

    const ROLE_USER        = 'user';
    const ROLE_ADMIN       = 'admin';
    const ROLE_POS_MANAGER = 'pos_manager';

    const ROLES = [
        self::ROLE_USER        => 'User',
        self::ROLE_ADMIN       => 'Admin',
        self::ROLE_POS_MANAGER => 'Pos Manager',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userInfo()
    {
        return $this->hasOne('App\UserInfo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumers()
    {
        return $this->hasMany(Consumer::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function location()
    {
        if (in_array($this->role, [self::ROLE_ADMIN])) {
            return $this->hasOneThrough(Location::class, UserCompany::class, 'user_id', 'id', 'id', 'company_id');
        }

        return $this->hasOneThrough(Location::class, UserLocation::class, 'user_id', 'id', 'id', 'location_id');
    }
}
