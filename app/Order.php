<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
     * @var string[]
     */
    protected $appends = ['date', 'translated_day'];

    /**
     * @var array
     */
    protected $fillable = ['menuitem_id', 'consumer_id', 'subsidization_organization_id', 'type', 'day', 'pickedup', 'pickedup_at', 'quantity', 'is_subsidized', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== User::ROLE_USER) {
                $builder->whereHas('menuItem.menuCategory.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id)
                        ->orWhere('locations.id', auth()->user()->location_id);
                })->orWhereHas('consumer.locationgroup.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id)
                        ->orWhere('locations.id', auth()->user()->location_id);
                });
            }
        });
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeHasSubsidization($query)
    {
        return $query->where(['is_subsidized' => Order::IS_SUBSIDIZED]);
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
    public function menuItem()
    {
        return $this->belongsTo('App\MenuItem', 'menuitem_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuCategory(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        $menuItem = $this->belongsTo(MenuItem::class, 'menuitem_id');

        return $menuItem->getResults()->belongsTo(MenuCategory::class, 'menu_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subsidizationOrganization()
    {
        return $this->belongsTo('App\SubsidizationOrganization');
    }

    /**
     * @return false|string
     */
    public function getDateAttribute()
    {
        return date('l, d.m.Y', strtotime($this->day));
    }

    /**
     * @return false|string
     */
    public function getTranslatedDayAttribute()
    {
        try {
            return Carbon::parse($this->day)->translatedFormat('l, d.m.Y');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @return bool
     */
    public function isPosOrder(): bool
    {
        return $this->type === self::TYPE_POS_ORDER;
    }
}
