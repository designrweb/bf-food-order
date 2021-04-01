<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * This is the model class for table "payment_dump".
 *
 * @property int         $id
 * @property string|null $file_name
 * @property int         $status
 * @property int         $company_id
 * @property string|null $requested_at
 * @property string      $created_at
 * @property string      $updated_at
 */
class PaymentDump extends Model
{
    const STATUS_UPLOADED   = 0;
    const STATUS_PROCESSED  = 1;
    const STATUS_DUPLICATED = 2;

    const STATUSES = [
        self::STATUS_UPLOADED   => 'UPLOADED',
        self::STATUS_PROCESSED  => 'PROCESSED',
        self::STATUS_DUPLICATED => 'DUPLICATED',
    ];

    /**
     * @var array
     */
    protected $fillable = ['file_name', 'status', 'company_id', 'created_at', 'updated_at', 'requested_at'];

}
