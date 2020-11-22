<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Class ImageService
 *
 * @package App\Services
 */
class ImageService
{

    /**
     * @param array      $request
     * @param Model|null $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(array $request, Model $model = null)
    {
        if (!empty($request['_imageBase64'])) {
            $message = 'Bild hochgeladen';
            $success = true;

            $_entityName  = trim(strtolower($request['_entityName']));
            $_entityModel = !empty($model) ? get_class($model) : '\App\\' . Str::studly(Str::singular($_entityName));

            if (!is_subclass_of($_entityModel, Model::class)) {
                return response()->json([
                    'message' => 'Wrong entity model',
                    'success' => false,
                ]);
            }

            $_entityId       = !empty($model->id) ? $model->id : $request['_entityId'];
            $_imageFieldName = $request['_imageFieldName'];
            $_imageBase64    = $request['_imageBase64'];
            $_imageBase64    = str_replace(' ', '+', $_imageBase64);

            try {
                if (!$_entityModel::IS_BASE64) {
                    $extension    = explode('/', mime_content_type($_imageBase64))[1];
                    $_imageBase64 = str_replace('data:image/png;base64,', '', $_imageBase64);
                    $fileName     = time() . '.' . $extension;

                    Storage::disk($_entityName)->put($fileName, base64_decode($_imageBase64));

                    $_imageBase64 = $fileName;
                }

                $model = $_entityModel::find($_entityId);

                if (!empty($model->{$_imageFieldName})) {
                    $imagePathForDelete = storage_path('app/public/' . $_entityName . '/' . str_replace(asset($_entityName) . '/', '', $model->{$_imageFieldName}));
                    if (file_exists($imagePathForDelete)) {
                        @unlink($imagePathForDelete);
                    }
                }

                $model->update([
                    $_imageFieldName => $_imageBase64
                ]);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $success = false;
            }

            return response()->json([
                'message' => $message,
                'success' => $success,
            ]);
        }
    }

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage($request)
    {
        $message = 'Bild entfernt';
        $success = true;

        $_entityName  = trim(strtolower($request->_entityName));
        $_entityModel = !empty($model) ? get_class($model) : '\App\\' . Str::studly(Str::singular($_entityName));

        if (!is_subclass_of($_entityModel, Model::class)) {
            return response()->json([
                'message' => 'Wrong entity model',
                'success' => false,
            ]);
        }

        $_entityId       = $request->_entityId;
        $_imageFieldName = $request->_imageFieldName;

        try {
            $model = $_entityModel::find($_entityId);

            if (!empty($model->{$_imageFieldName})) {
                $imagePathForDelete = storage_path('app/public/' . $_entityName . '/' . str_replace(asset($_entityName) . '/', '', $model->{$_imageFieldName}));
                if (file_exists($imagePathForDelete)) {
                    @unlink($imagePathForDelete);
                }
            }

            $model->{$_imageFieldName} = null;
            $model->save();
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $success = false;
        }

        return response()->json([
            'message' => $message,
            'success' => $success,
        ]);
    }
}