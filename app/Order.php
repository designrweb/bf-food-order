<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $menuitem_id
 * @property integer $consumer_id
 * @property integer $subsidization_organization_id
 * @property int $type
 * @property string $day
 * @property boolean $pickedup
 * @property string $pickedup_at
 * @property boolean $quantity
 * @property boolean $is_subsidized
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Consumer $consumer
 * @property MenuItem $menuItem
 * @property SubsidizationOrganization $subsidizationOrganization
 */
class Order extends Model
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
    protected $fillable = ['menuitem_id', 'consumer_id', 'subsidization_organization_id', 'type', 'day', 'pickedup', 'pickedup_at', 'quantity', 'is_subsidized', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumer()
    {
        return $this->belongsTo('App\Consumer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuItem()
    {
        return $this->belongsTo('App\MenuItem', 'menuitem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsidizationOrganization()
    {
        return $this->belongsTo('App\SubsidizationOrganization');
    }
}
