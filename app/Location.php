<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property integer         $id
 * @property string          $name
 * @property string          $street
 * @property int             $zip
 * @property string          $city
 * @property integer         $company_id
 * @property string          $email
 * @property string          $image_name
 * @property LocationGroup[] $locationGroups
 */
class Location extends Model
{

    const IMAGE_FOLDER = 'location';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'street', 'zip', 'city', 'email', 'image_name', 'company_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('locations.company_id', auth()->user()->company_id)
                    ->orWhere('locations.id', auth()->user()->location_id);
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @param $value
     * @return string|null
     */
    public function getImageNameAttribute($value)
    {
        if (!empty($value)) {
            return asset(self::IMAGE_FOLDER . DIRECTORY_SEPARATOR . $value);
        }

        return null;
    }

    /**
     * @param $value
     */
    public function setImageNameAttribute($value)
    {
        $this->attributes['image_name'] = str_replace(asset(self::IMAGE_FOLDER) . DIRECTORY_SEPARATOR, '', $value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locationGroups()
    {
        return $this->hasMany(LocationGroup::class, 'location_id', 'id');
    }

}
