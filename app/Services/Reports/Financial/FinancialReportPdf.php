<?php

namespace App\Services\Reports\Financial;

use App\Services\Reports\PdfReportTemplateProvider;
use Illuminate\Support\Facades\View;

/**
 * Class FinancialReportPdf
 *
 * TODO: remove in the future if not needed
 *
 * @package App\Services\Reports\Financial
 */
class FinancialReportPdf extends FinancialReportComponent
{
    use PdfReportTemplateProvider;

    /**
     * @param $startDate
     * @param $endDate
     * @param $location
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public function generate($startDate, $endDate, $location): string
    {
        $this->initReport($startDate, $endDate, $location);

        $header  = $this->getHeaderContent();
        $footer  = $this->getFooterContent();
        $content = $this->getCredentialsContent();
        $content .= View::make('reports.pdf.financial',
            [
                'incomingTransactions' => $this->incomingTransactions,
                'manuallyBookedMoney'  => $this->manuallyBookedMoney,
                'orderedMeals'         => $this->orderedMeals,
                'spontaneousOrders'    => $this->spontaneousOrders,
                'voucherOrders'        => $this->voucherOrders,
                'location'             => $location,
                'startDate'            => $startDate,
                'endDate'              => $endDate
            ]
        )->render();

        $title = 'Financial report';

        $mpdf = $this->getPdf($content, $title, $header, $footer);

        return $mpdf->Output('filename.pdf', \Mpdf\Output\Destination::DOWNLOAD);
    }
}
