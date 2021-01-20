<?php

namespace App\Services;

use App\Services\Reports\FinancialReportGenerator;
use App\Services\Reports\SubsidizationReportGenerator;

/**
 * Class ReportGenerationService
 * Report generators factory
 */
class ReportGenerationService
{
    /** @var FinancialReportGenerator */
    private $financialReportGenerator;

    /** @var SubsidizationReportGenerator */
    private $subsidizationReportGenerator;

    /**
     * ReportGenerationService constructor.
     *
     * @param FinancialReportGenerator     $financialReportGenerator
     * @param SubsidizationReportGenerator $subsidizationReportGenerator
     */
    public function __construct(
        FinancialReportGenerator $financialReportGenerator,
        SubsidizationReportGenerator $subsidizationReportGenerator
    )
    {
        $this->financialReportGenerator = $financialReportGenerator;
        $this->subsidizationReportGenerator = $subsidizationReportGenerator;
    }

    /**
     * @return FinancialReportGenerator
     */
    public function financialReport(): FinancialReportGenerator
    {
        return $this->financialReportGenerator;
    }

    /**
     * @return SubsidizationReportGenerator
     */
    public function subsidizationReport(): SubsidizationReportGenerator
    {
        return $this->subsidizationReportGenerator;
    }
}
