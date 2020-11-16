<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $start_date
 * @property string $end_date
 * @property int $created_at
 * @property int $updated_at
 */
class Vacation extends Model
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
    protected $fillable = ['name', 'start_date', 'end_date', 'created_at', 'updated_at'];

}
