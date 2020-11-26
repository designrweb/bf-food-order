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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class);
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

}
