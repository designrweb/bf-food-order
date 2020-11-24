<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $street
 * @property int     $zip
 * @property string  $city
 * @property integer $company_id
 * @property string  $email
 * @property string  $slug
 * @property string  $image_name
 */
class Location extends Model
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
    protected $fillable = ['name', 'street', 'zip', 'city', 'email', 'slug', 'image_name', 'company_id'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::of($value)->slug('-');
    }

    /**
     * @return array
     */
    public static function getLocationsList()
    {
        $locationsArray = [];
        $allLocations   = self::all();

        foreach ($allLocations as $location) {
            $locationsArray[] = [
                'id'   => $location->id,
                'name' => $location->name,
            ];
        }

        return $locationsArray;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class);
    }

}
