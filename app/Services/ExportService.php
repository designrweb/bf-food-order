<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 * Class ExportService
 *
 * @package App\Services
 */
class ExportService
{
    const DEFAULT_TYPE = 'Xlsx';

    /**
     * @param Request $request
     * @param         $service
     * @param         $collectionResource
     * @param         $model
     * @return mixed
     */
    public function export(Request $request, $service, $collectionResource, $model)
    {
        $type      = strtoupper($request->get('exportType', self::DEFAULT_TYPE));
        $extension = strtolower($type);

        return (new CollectionExport($request, $service, $collectionResource, $model))->download('data.' . $extension, constant('\Maatwebsite\Excel\Excel::' . $type));
    }
}