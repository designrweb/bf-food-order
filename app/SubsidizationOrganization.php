<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $zip
 * @property string $city
 * @property string $street
 * @property int $created_at
 * @property int $updated_at
 * @property int $deleted_at
 */
class SubsidizationOrganization extends Model
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
    protected $fillable = ['name', 'zip', 'city', 'street', 'created_at', 'updated_at', 'deleted_at'];

}
