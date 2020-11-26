<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string  $setting_name
 * @property string  $visible_name
 * @property string  $value
 * @property integer $company_id
 * @property mixed   $created_at
 * @property mixed   $updated_at
 */
class Setting extends Model
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
    protected $fillable = ['setting_name', 'visible_name', 'value', 'created_at', 'updated_at', 'company_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

}
