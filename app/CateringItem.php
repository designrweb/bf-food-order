<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer          $id
 * @property integer          $catering_category_id
 * @property string           $name
 * @property string           $description
 * @property string           $imageurl
 * @property integer          $status
 * @property mixed            $created_at
 * @property mixed            $updated_at
 * @property CateringCategory $cateringCategory
 */
class CateringItem extends Model
{

    const STATUS_ACTIVE   = 1;
    const STATUS_DISABLED = 0;

    const STATUSES = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_DISABLED => 'Disabled',
    ];

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['catering_category_id', 'name', 'description', 'imageurl', 'status', 'created_at', 'updated_at'];

    /**
     * @var string[]
     */
    protected $appends = ['status_human', 'created_at_human', 'updated_at_human'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cateringCategory()
    {
        return $this->belongsTo('App\CateringCategory');
    }

    /**
     * @return false|string
     */
    public function getCreatedAtHumanAttribute()
    {
        return Carbon::parse($this->created_at)->translatedFormat('l, d.m.Y');
    }

    /**
     * @return false|string
     */
    public function getUpdatedAtHumanAttribute()
    {
        return Carbon::parse($this->updated_at)->translatedFormat('l, d.m.Y');
    }

    /**
     * @return string
     */
    public function getStatusHumanAttribute()
    {
        return self::STATUSES[$this->status];
    }
}
