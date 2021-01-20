<?php

namespace App\Services\Reports;

use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;

/**
 * Trait PdfReportTemplateProvider
 *
 * @package App\Services\Reports
 */
trait PdfReportTemplateProvider
{
    /**
     * @param      $content
     * @param      $title
     * @param null $header
     * @param null $footer
     * @return Mpdf
     * @throws \Mpdf\MpdfException
     */
    protected function getPdf($content, $title, $header = null, $footer = null): Mpdf
    {
        $directory = storage_path('app/files/reports/');

        $mpdf = new Mpdf([
            'tempDir'      => $directory,
            'mode'         => 'c',
            'marginTop'    => 30,
            'marginHeader' => 5,
            'marginFooter' => 0,
            'marginLeft'   => 0,
            'marginRight'  => 0,
        ]);

        $mpdf->defaultfooterline = 0;
        $mpdf->defaultheaderline = 0;

        $mpdf->setTitle($title);
        $mpdf->SetHeader($header);
        $mpdf->SetFooter($footer);

        $mpdf->WriteHTML($content);

        return $mpdf;
    }

    /**
     * @return string
     */
    protected function getHeaderContent()
    {
        return View::make('reports.pdf._partials._header')->render();
    }

    /**
     * @return string
     */
    protected function getFooterContent()
    {
        return View::make('reports.pdf._partials._footer')->render();
    }

    /**
     * @return string
     */
    protected function getCredentialsContent()
    {
        return View::make('reports.pdf._partials._credentials')->render();
    }
}
