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
    const DEFAULT_TYPE = 'XLSX';

    const TYPES = [
        'XLSX' => 'xlsx',
        'HTML' => 'html',
        'CSV'  => 'csv',
        'MPDF' => 'pdf',
    ];

    /**
     * @param Request $request
     * @param         $service
     * @param         $collectionResource
     * @param         $model
     * @param string  $method
     * @param array   $params
     * @param string  $fieldsMethod
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, $service, $collectionResource, $model, $method = 'all', $params = [], $fieldsMethod = 'getIndexFieldsLabels')
    {
        $type      = $request->get('exportType', self::TYPES[self::DEFAULT_TYPE]);
        $extension = self::TYPES[$type];

        return (new CollectionExport($request, $service, $collectionResource, $model, $method, $params, $fieldsMethod))->download('data.' . $extension, constant('\Maatwebsite\Excel\Excel::' . $type));
    }
}