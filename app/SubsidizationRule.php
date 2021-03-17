<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                    $id
 * @property integer                    $subsidization_organization_id
 * @property integer                    $created_by
 * @property string                     $rule_name
 * @property string                     $start_date
 * @property string                     $end_date
 * @property string                     $created_at
 * @property string                     $updated_at
 * @property SubsidizationOrganization  $subsidizationOrganization
 * @property User                       $user
 * @property ConsumerSubsidization[]    $consumerSubsidizations
 * @property subsidizedMenuCategories[] $subsidizedMenuCategories
 */
class SubsidizationRule extends Model
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
    protected $fillable = ['subsidization_organization_id', 'created_by', 'rule_name', 'start_date', 'end_date', 'created_at', 'updated_at'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('subsidizationOrganization', function ($query) {
                    $query->where('subsidization_organizations.company_id', auth()->user()->company_id);
                });
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsidizationOrganization()
    {
        return $this->belongsTo('App\SubsidizationOrganization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function consumerSubsidizations()
    {
        return $this->hasMany('App\ConsumerSubsidization');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subsidizedMenuCategories()
    {
        return $this->hasMany(SubsidizedMenuCategories::class, 'subsidization_rule_id', 'id');
    }

    /**
     * @param $value
     */
    public function setStartDateAttribute($value)
    {
        $this->attributes['start_date'] = date('Y-m-d', strtotime($value));
    }

    /**
     * @param $value
     */
    public function setEndDateAttribute($value)
    {
        $this->attributes['end_date'] = date('Y-m-d', strtotime($value));
    }
}
