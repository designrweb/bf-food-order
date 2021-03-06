<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer           $id
 * @property integer           $subsidization_rule_id
 * @property string            $subsidization_start
 * @property string            $subsidization_end
 * @property string            $subsidization_document
 * @property string            $created_at
 * @property string            $updated_at
 * @property string            $deleted_at
 * @property SubsidizationRule $subsidizationRule
 */
class ConsumerSubsidization extends Model
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
    protected $fillable = ['subsidization_rule_id', 'subsidization_start', 'subsidization_end', 'subsidization_document', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsidizationRule()
    {
        return $this->belongsTo(SubsidizationRule::class, 'subsidization_rule_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Consumer::class);
    }

    /**
     * @param $value
     */
    public function setSubsidizationStartAttribute($value)
    {
        $this->attributes['subsidization_start'] = !empty($value) ? date('Y-m-d', strtotime
        ($value)) : null;
    }

    /**
     * @param $value
     */
    public function setSubsidizationEndAttribute($value)
    {
        $this->attributes['subsidization_end'] = !empty($value) ? date('Y-m-d', strtotime($value)
        ) : null;
    }
}
