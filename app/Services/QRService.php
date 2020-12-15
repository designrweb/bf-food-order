<?php

namespace App\Services;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;

class QRService
{

    /**
     * @param      $model
     * @param bool $toBase64
     * @return false|mixed|string
     */
    public static function codeToImage(Model $model, $toBase64 = true)
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_JPG,
            'eccLevel'   => QRCode::ECC_H,
            'scale'      => 10
        ]);

        $q = new QRCode($options);
        $render = $q->render($model->qrcode->qr_code_hash);

        if ($toBase64) {
            return base64_decode(explode(',', $render)[1]);
        }

        return $render;
    }
}