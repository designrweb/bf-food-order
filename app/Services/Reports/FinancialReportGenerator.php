<?php

namespace App\Services\Reports;

use App\Services\LocationService;
use App\Services\Reports\Financial\FinancialReportCsv;
use App\Services\Reports\Financial\FinancialReportPdf;

/**
 * Class FinancialReportGenerator
 *
 * @package App\Services\Reports
 */
class FinancialReportGenerator
{
    const REPORT_TYPE_CSV = 'csv';
    const REPORT_TYPE_PDF = 'pdf';

    /** @var LocationService*/
    private $locationService;

    /** @var FinancialReportCsv */
    private $financialReportCsv;

    /** @var FinancialReportPdf */
    private $financialReportPdf;

    /**
     * FinancialReportGenerator constructor.
     *
     * @param LocationService    $locationService
     * @param FinancialReportCsv $financialReportCsv
     * @param FinancialReportPdf $financialReportPdf
     */
    public function __construct(
        LocationService $locationService,
        FinancialReportCsv $financialReportCsv,
        FinancialReportPdf $financialReportPdf
    )
    {
        $this->locationService = $locationService;
        $this->financialReportCsv = $financialReportCsv;
        $this->financialReportPdf = $financialReportPdf;
    }

    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function generateReport($data)
    {
        $location = $this->locationService->getOne($data['location_id']);

        switch ($data['reportType']) {
            case self::REPORT_TYPE_PDF:
                return $this->generatePdf($data['start_date'], $data['end_date'], $location); // todo why send object
            case self::REPORT_TYPE_CSV:
                return  $this->generateCsv($data['start_date'], $data['end_date'], $location);
        }
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $location
     * @return mixed
     * @throws \Exception
     */
    public function generateCsv($startDate, $endDate, $location)
    {
        try {
            return $this->financialReportCsv->generate($startDate, $endDate, $location);

        } catch (\Throwable $t) {
                throw new \Exception($t->getMessage());
        }
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $location
     * @return mixed
     * @throws \Exception
     */
    public function generatePdf($startDate, $endDate, $location)
    {
        try {
            return $this->financialReportPdf->generate($startDate, $endDate, $location);
        } catch (\Throwable $t) {
            throw new \Exception($t->getMessage());
        }
    }
}
