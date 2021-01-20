<?php

namespace App\Http\Controllers;

use App\Http\Requests\FinancialReportFormRequest;
use App\Http\Requests\SubsidizationReportFormRequest;
use App\Order;
use App\Services\LocationService;
use App\Services\ReportGenerationService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReportController extends Controller
{
    /** @var ReportGenerationService*/
    protected $service;

    /** @var LocationService */
    private $locationService;

    /**
     * ReportController constructor.
     *
     * @param ReportGenerationService $service
     * @param LocationService         $locationService
     */
    public function __construct(ReportGenerationService $service, LocationService $locationService)
    {
        $this->service         = $service;
        $this->locationService = $locationService;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $locationsList = $this->locationService->getList();

        return view('reports.index', compact('locationsList'));
    }

    /**
     * @param FinancialReportFormRequest $request
     * @return mixed
     */
    public function financialReport(FinancialReportFormRequest $request)
    {
        try {
            return $this->service->financialReport()->generateReport($request->all());

        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }

    /**
     * @param SubsidizationReportFormRequest $request
     * @return mixed
     */
    public function subsidizationReport(SubsidizationReportFormRequest $request)
    {
        $startDate      = date('Y-m-d', strtotime($request->input('start_date')));
        $endDate        = date('Y-m-d', strtotime($request->input('end_date')));
        $organizationId = $request->input('organization_id');
        $reportType     = $request->input('report_type');

        try {
            switch ($reportType) {
                case Order::TYPE_PRE_ORDER:
                    return $this->service->subsidizationReport()->generatePreOrderedSubsidizationReport($startDate, $endDate, $organizationId);
                case Order::TYPE_POS_ORDER:
                    return $this->service->subsidizationReport()->generatePosOrderedSubsidizationReport($startDate, $endDate, $organizationId);
                default:
                    // todo change exception
                    throw new ModelNotFoundException('type not found.');
            }
        } catch (\Exception $e) {
            return response($e->getMessage());
        }
    }
}
