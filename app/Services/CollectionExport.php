<?php

namespace App\Services;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
    $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
});

Sheet::macro('autoSize', function (Sheet $sheet) {
    $sheet->setAutoSize(true);
});

/**
 * Class CollectionExport
 *
 * @package App\Services
 */
class CollectionExport implements FromArray, WithHeadings, WithEvents
{
    use Exportable;

    /**
     * @var
     */
    protected $service;

    /**
     * @var
     */
    protected $request;

    /**
     * @var
     */
    protected $collectionResource;

    /**
     * @var
     */
    protected $model;

    /**
     * @var
     */
    protected $fields;

    /**
     * @var
     */
    protected $method;

    /**
     * @var array|mixed
     */
    protected $params;

    /**
     * CollectionExport constructor.
     *
     * @param $request
     * @param $service
     * @param $collectionResource
     * @param $model
     * @param $method
     * @param $params
     * @param $fieldsMethod
     */
    public function __construct($request, $service, $collectionResource, $model, $method, $params, $fieldsMethod)
    {
        $this->request            = $request;
        $this->service            = $service;
        $this->collectionResource = $collectionResource;
        $this->model              = $model;
        $this->fields             = call_user_func_array([$this->service, $fieldsMethod], [new $this->model]);
        $this->method             = $method;
        $this->params             = $params;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return array_column($this->fields, 'label');
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $formattedData = [];
        request()->merge(['itemsPerPage' => 0]);
        $call = call_user_func_array([$this->service, $this->method], $this->params);

        if ($this->collectionResource) {
            $data           = (new $this->collectionResource($call))
                ->toArray($this->request);
            $collectionData = $data['data'];
        } else {
            $collectionData = $call;
        }

        foreach ($collectionData as $item) {
            $row = [];

            foreach ($this->fields as $field) {
                $value                = $this->getValueByIndexesPath($field, $item);
                $row[$field['label']] = $value;
            }

            $formattedData[] = $row;
        }

        return $formattedData;
    }

    /**
     * @param $field
     * @param $item
     * @return string
     */
    public function getValueByIndexesPath($field, $item): string
    {
        $indexes = explode('.', $field['key']);

        foreach ($indexes as $index) {
            $item = $item[$index] ?? '';
        }

        return $item;
    }

    /**
     * @return \Closure[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestDataColumn = $event->getSheet()->getHighestDataColumn();

                $event->sheet->autoSize();
                $event->sheet->getDelegate()->getParent()->getDefaultStyle()->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $event->sheet->styleCells(
                    'A1:' . $highestDataColumn . '1',
                    [
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'DADADA',
                            ]
                        ]
                    ]
                );
            },
        ];
    }
}
