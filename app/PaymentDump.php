<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "payment_dump".
 *
 * @property int         $id
 * @property string|null $file_name
 * @property int         $status
 * @property string|null $requested_at
 * @property string      $created_at
 * @property string      $updated_at
 */
class PaymentDump extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['file_name', 'status', 'created_at', 'updated_at', 'requested_at'];
}
