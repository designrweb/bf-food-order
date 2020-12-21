<?php

namespace App\Components;

use Illuminate\Support\Facades\Storage;

/**
 * Class ImageService
 *
 * @package App\Services
 */
class ImageComponent
{

    /**
     * @param $imageData
     * @param $folder
     * @return false|string
     */
    public static function storeInFile($imageData, $folder)
    {
        try {
            $extension = explode('/', mime_content_type($imageData))[1];
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $fileName  = time() . '.' . $extension;

            Storage::disk($folder)->put($fileName, base64_decode($imageData));
        } catch (\Exception $e) {
            return false;
        }

        return $fileName;
    }

    /**
     * @param $imageData
     * @return string
     */
    public static function storeEncrypt($imageData)
    {
        $imageData = str_replace(' ', '+', $imageData);
        $imageData = self::encrypt($imageData);

        return $imageData;
    }

    /**
     * @param $data
     * @return string
     */
    public static function encrypt($data)
    {
        $key            = env('KEY_FILE_ENCRYPT');
        $encryption_key = base64_decode($key);
        $iv             = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted      = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);

        return base64_encode($encrypted . '::' . $iv);
    }

    /**
     * @param $data
     * @return false|string
     */
    public static function decrypt($data)
    {
        $key            = env('KEY_FILE_ENCRYPT');
        $encryption_key = base64_decode($key);
        [$encrypted_data, $iv] = explode('::', base64_decode($data), 2);

        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    /**
     * @param $fileName
     * @param $folder
     * @return bool
     */
    public static function removeImage($fileName, $folder)
    {
        try {
            $imagePathForDelete = storage_path('app/public/' . $folder . DIRECTORY_SEPARATOR . str_replace(asset($folder) . DIRECTORY_SEPARATOR, '', $fileName));
            if (file_exists($imagePathForDelete)) {
                @unlink($imagePathForDelete);
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }


}