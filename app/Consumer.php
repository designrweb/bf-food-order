<?php

namespace App;

use App\Components\ImageComponent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * @property integer       $id
 * @property integer       $location_group_id
 * @property integer       $user_id
 * @property string        $account_id
 * @property string        $firstname
 * @property string        $lastname
 * @property string        $birthday
 * @property string        $imageurl
 * @property float         $balance
 * @property int           $balance_limit
 * @property string        $created_at
 * @property string        $updated_at
 * @property string        $deleted_at
 * @property LocationGroup $locationGroup
 * @property Location      $location
 * @property Company       $company
 * @property User          $user
 */
class Consumer extends Model
{
    use SoftDeletes;

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var string[]
     */
    protected $appends = ['full_name'];

    /**
     * @var array
     */
    protected $fillable = ['location_group_id', 'user_id', 'account_id', 'firstname', 'lastname', 'birthday', 'imageurl', 'balance', 'balance_limit', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * @return \Closure|mixed|void
     */
    protected static function boot()
    {
        parent::boot();

        return static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->whereHas('locationgroup.location', function ($query) {
                    $query->where('locations.company_id', auth()->user()->company_id)
                        ->orWhere('locations.id', auth()->user()->location_id);
                });
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locationgroup()
    {
        return $this->belongsTo('App\LocationGroup', 'location_group_id', 'id');
    }

    /**
     * @return mixed
     */
    public function location()
    {
        $locationGroup = $this->belongsTo(LocationGroup::class, 'location_group_id');

        return $locationGroup->getResults()->belongsTo(Location::class, 'location_id');
    }

    /**
     * @return mixed
     */
    public function company()
    {
        $locationGroup = $this->belongsTo(LocationGroup::class, 'location_group_id');
        $location      = $locationGroup->getResults()->belongsTo(Location::class, 'location_id');

        return $location->getResults()->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageurlAttribute($value)
    {
        if (!empty($value)) {
            return ImageComponent::decrypt($value);
        }

        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function qrcode()
    {
        return $this->hasOne(ConsumerQrCode::class, 'consumer_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preOrderedItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class, 'consumer_id', 'id')
            ->where('pickedup', 0)
            ->where('type', Order::TYPE_PRE_ORDER)
            ->where('day', date('Y-m-d'));
    }

    public function pickedUpPreOrderedItems()
    {
        return $this->hasMany(Order::class, 'consumer_id', 'id')
            ->where('pickedup', 1)
            ->where('type', Order::TYPE_PRE_ORDER)
            ->where('day', date('Y-m-d'));
    }

    public function pickedUpPosOrderedItems()
    {
        return $this->hasMany(Order::class, 'consumer_id', 'id')
            ->where('pickedup', 1)
            ->where('type', Order::TYPE_POS_ORDER)
            ->where('pickedup_at', 'like', date('Y-m-d') . '%');
    }

    /**
     * @return mixed
     */
    public function getSubsidizedMenuCategoriesAttribute()
    {
        return DB::table('subsidized_menu_categories')
            ->join('subsidization_rules', 'subsidization_rules.id', '=', 'subsidized_menu_categories.subsidization_rule_id')
            ->join('consumer_subsidizations', 'consumer_subsidizations.subsidization_rule_id', '=', 'subsidization_rules.id')
            ->where(function ($query) {
                $query->where('subsidization_start', '<=', date('Y-m-d'))
                    ->orWhere('subsidization_start', null);
            })
            ->where(function ($query) {
                $query->where('subsidization_end', '>=', date('Y-m-d'))
                    ->orWhere('subsidization_end', null);
            })
            ->where(function ($query) {
                $query->where('start_date', '<=', date('Y-m-d'))
                    ->orWhere('start_date', null);
            })
            ->where(function ($query) {
                $query->where('end_date', '>=', date('Y-m-d'))
                    ->orWhere('end_date', null);
            })
            ->where('consumer_id', $this->id)
            ->where('percent', '>', 0)
            ->get();
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function subsidization()
    {
        return $this->hasOne(ConsumerSubsidization::class, 'consumer_id', 'id');
    }

    /**
     * @param $date
     * @return bool
     */
    // todo move to service and refactor it
    public function isSubsidized($date): bool
    {
        $subsidization     = $this->subsidization;
        $subsidizationRule = optional($subsidization)->subsidizationRule;

        if (!empty($subsidization->subsidization_rule_id)) {
            if (
                empty($subsidizationRule->start_date)
                && empty($subsidizationRule->end_date)
                && empty($subsidization->subsidization_start)
                && empty($subsidization->subsidization_end)
            ) {
                return true;
            }

            if (
                !empty($subsidizationRule->start_date)
                && !empty($subsidizationRule->end_date)
                && !empty($subsidization->subsidization_start)
                && !empty($subsidization->subsidization_end)
            ) {
                return $this->isBetween($date, $subsidizationRule->start_date, $subsidizationRule->end_date)
                    && $this->isBetween($date, $subsidization->subsidization_start, $subsidization->subsidization_end);
            }

            if (
                empty($subsidizationRule->start_date)
                && empty($subsidizationRule->end_date)
                && !empty($subsidization->subsidization_start)
                && !empty($subsidization->subsidization_end)
            ) {
                return $this->isBetween($date, $subsidization->subsidization_start, $subsidization->subsidization_end);
            }

            if (
                !empty($subsidizationRule->start_date)
                && !empty($subsidizationRule->end_date)
                && empty($subsidization->subsidization_start)
                && empty($subsidization->subsidization_end)
            ) {
                return $this->isBetween($date, $subsidizationRule->start_date, $subsidizationRule->end_date);
            }
        }

        return false;
    }

    /**
     * @param $date
     * @param $rangeStart
     * @param $rangeFinish
     * @return bool
     */
    protected function isBetween($date, $rangeStart, $rangeFinish): bool
    {
        if ($date > date('Y-m-d', strtotime($rangeFinish)) || $date < date('Y-m-d', strtotime($rangeStart))) {
            return false;
        }

        return true;
    }

    /**
     * @param $value
     */
    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = date('Y-m-d', strtotime($value));
    }
}
