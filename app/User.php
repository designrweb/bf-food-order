<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property integer  $id
 * @property string   $email
 * @property integer  $company_id
 * @property integer  $location_id
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
class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    const ROLE_USER        = 'user';
    const ROLE_ADMIN       = 'admin';
    const ROLE_POS_MANAGER = 'pos_manager';
    const ROLE_SUPER_ADMIN = 'super_admin';

    const ROLES = [
        self::ROLE_USER        => 'User',
        self::ROLE_ADMIN       => 'Admin',
        self::ROLE_POS_MANAGER => 'Pos Manager',
    ];

    const SALUTATION_MR  = 'mr';
    const SALUTATION_MRS = 'mrs';

    const SALUTATIONS = [
        self::SALUTATION_MR  => 'Mr.',
        self::SALUTATION_MRS => 'Mrs.',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role', 'location_id', 'company_id'
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'id', 'location_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWhereCompany($query)
    {
        return $query->where(function ($query) {
            $query->where(function ($q) {
                $q->where('users.company_id', auth()->user()->company_id)
                    ->where('users.id', '!=', auth()->user()->id);
            })->orWhereHas('location', function ($relation) {
                $relation->where('locations.company_id', auth()->user()->company_id);
            });
        });
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
