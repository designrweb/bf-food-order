<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $location_id
 * @property integer $menu_category_id
 * @property string $name
 * @property string $availability_date
 * @property string $description
 * @property string $imageurl
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property Location $location
 * @property MenuCategory $menuCategory
 */
class MenuItem extends Model
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
    protected $fillable = ['location_id', 'menu_category_id', 'name', 'availability_date', 'description', 'imageurl', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menuCategory()
    {
        return $this->belongsTo('App\MenuCategory');
    }
}
