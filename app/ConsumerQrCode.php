<?php

namespace App;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $consumer_id
 * @property string $qr_code_hash
 * @property Consumer $consumer
 */
class ConsumerQrCode extends Model
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
    protected $fillable = ['consumer_id', 'qr_code_hash'];

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function consumer()
    {
        return $this->belongsTo('App\Consumer');
    }


    public function getQrCodeImageAttribute()
    {
        $options = new QROptions([
            'outputType'     => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'       => QRCode::ECC_H,
            'pngCompression' => -1,
            'scale'          => 10

        ]);

        $q        = new QRCode($options);
        $tmpFile = tempnam(sys_get_temp_dir(), 'qr');

        return $q->render($this->qr_code_hash, $tmpFile);
    }
}
