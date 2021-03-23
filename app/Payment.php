<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer  $id
 * @property integer  $order_id
 * @property integer  $consumer_id
 * @property float    $amount
 * @property boolean  $type
 * @property string   $comment
 * @property string   $created_at
 * @property string   $updated_at
 * @property string   $transacted_at
 * @property Consumer $consumer
 * @property Order    $order
 */
class Payment extends Model
{
    const TYPE_BANK_TRANSACTION                         = 1; //positive
    const TYPE_MANUAL_TRANSACTION                       = 2; //positive or negative
    const TYPE_VOUCHER                                  = 3; //negative
    const TYPE_PRE_ORDER                                = 4; //negative
    const TYPE_PRE_ORDER_CANCELLATION                   = 5; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED                     = 6; //negative
    const TYPE_PRE_ORDER_SUBSIDIZED_REFUND              = 7; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION        = 8; //positive
    const TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND = 9; //negative
    const TYPE_POS_ORDER                                = 10; //negative
    const TYPE_POS_ORDER_SUBSIDIZED                     = 11; //negative
    const TYPE_POS_ORDER_SUBSIDIZED_REFUND              = 12; //positive

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['order_id', 'consumer_id', 'amount', 'type', 'comment', 'created_at', 'updated_at', 'transacted_at'];

    /**
     * @var string[]
     */
    protected $appends = ['created_at_human', 'amount_locale'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== User::ROLE_USER) {
                $builder->whereHas('order.menuItem.menuCategory.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id);
                })->orWhereHas('consumer.locationgroup.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id);
                });
            }
        });
    }

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
    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    /**
     * @return false|string
     */
    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->translatedFormat('l, d.m.Y');
    }

    /**
     * @return float|string|string[]
     */
    public function getAmountLocaleAttribute()
    {
        return str_replace('.', ',', $this->amount) . ' €';
    }
}
