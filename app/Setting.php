<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
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

    const DEFAULT_THEME_COLOR         = '#96c11f';
    const DEFAULT_SIDEBAR_THEME_COLOR = '#96c11f';
    const IMAGE_FOLDER                = 'setting';

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
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('settings.company_id', auth()->user()->company_id);
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }

}
