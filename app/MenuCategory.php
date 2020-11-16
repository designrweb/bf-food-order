<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property mixed $category_order
 * @property float $price
 * @property float $presaleprice
 * @property int $created_at
 * @property int $updated_at
 */
class MenuCategory extends Model
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
    protected $fillable = ['name', 'category_order', 'price', 'presaleprice', 'created_at', 'updated_at'];

}
