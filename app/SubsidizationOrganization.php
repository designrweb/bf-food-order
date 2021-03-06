<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string  $name
 * @property string  $zip
 * @property string  $city
 * @property string  $street
 * @property integer $company_id
 * @property int     $created_at
 * @property int     $updated_at
 * @property int     $deleted_at
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
    protected $fillable = ['name', 'zip', 'city', 'company_id', 'street', 'created_at', 'updated_at', 'deleted_at'];

    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== User::ROLE_USER) {
                $builder->where('subsidization_organizations.company_id', auth()->user()->company_id);
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

}
