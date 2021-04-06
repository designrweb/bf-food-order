<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer             $id
 * @property integer             $user_id
 * @property string              $delivery_date
 * @property mixed               $created_at
 * @property mixed               $updated_at
 * @property CateringOrderItem[] $orderItems
 * @property User                $user
 */
class CateringOrder extends Model
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
    protected $fillable = ['delivery_date', 'user_id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(CateringOrderItem::class, 'catering_order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
