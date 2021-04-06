<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int           $quantity
 * @property int           $catering_order_id
 * @property int           $catering_item_id
 * @property mixed         $created_at
 * @property mixed         $updated_at
 * @property CateringOrder $order
 * @property CateringItem  $cateringItem
 */
class CateringOrderItem extends Model
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
    protected $fillable = ['catering_order_id', 'catering_item_id', 'quantity', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(CateringOrder::class, 'id', 'catering_order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cateringItem()
    {
        return $this->hasOne(CateringItem::class, 'id', 'catering_item_id');
    }
}
