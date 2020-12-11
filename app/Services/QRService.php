<?php


namespace App\Services;


use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class QRService
{

    /**
     * @param $code
     * @return mixed
     */
    public static function codeToImage($code)
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_JPG,
            'eccLevel'   => QRCode::ECC_H,
            'scale'      => 10
        ]);

        $q = new QRCode($options);

        return $q->render($code);
    }
}