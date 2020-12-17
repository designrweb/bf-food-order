<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer                   $id
 * @property integer                   $menuitem_id
 * @property integer                   $consumer_id
 * @property integer                   $subsidization_organization_id
 * @property int                       $type
 * @property string                    $day
 * @property boolean                   $pickedup
 * @property string                    $pickedup_at
 * @property boolean                   $quantity
 * @property boolean                   $is_subsidized
 * @property string                    $created_at
 * @property string                    $updated_at
 * @property string                    $deleted_at
 * @property Consumer                  $consumer
 * @property MenuItem                  $menuItem
 * @property SubsidizationOrganization $subsidizationOrganization
 */
class Order extends Model
{
    use SoftDeletes;

    const TYPE_PRE_ORDER     = 1;
    const TYPE_POS_ORDER     = 2;
    const TYPE_VOUCHER_ORDER = 3;

    const TYPES = [
        self::TYPE_PRE_ORDER     => 'Vorbestellung',
        self::TYPE_POS_ORDER     => 'Spontanessen',
        self::TYPE_VOUCHER_ORDER => 'Bestellung mit Kioskbezahlung',
    ];

    const IS_SUBSIDIZED     = 1;
    const IS_NOT_SUBSIDIZED = 0;

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
