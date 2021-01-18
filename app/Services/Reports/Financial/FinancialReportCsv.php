<?php

namespace App\Services\Reports\Financial;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class FinancialReportCsv
 *
 * @package App\Services\Reports\Financial
 */
class FinancialReportCsv extends FinancialReportComponent
{
    protected $csvData = [];

    public function generate($startDate, $endDate, $location)
    {
        $this->initReport($startDate, $endDate, $location);

        $this->generateTotalTitle();
        $this->generateTotalBody($this->incomingTransactions, $this->manuallyBookedMoney, $this->orderedMeals, $this->spontaneousOrders, $this->voucherOrders);
        $this->generateDetailedTitle(__('reports.Incoming transactions'));
        $this->generateDetailedBlock($this->incomingTransactions);
        $this->generateDetailedTitle(__('reports.Manually booked money'));
        $this->generateDetailedBlock($this->manuallyBookedMoney);
        $this->generateDetailedTitle(__('reports.Ordered meals'));
        $this->generateDetailedBlock($this->orderedMeals);
        $this->generateDetailedTitle(__('reports.Spontaneous orders'));
        $this->generateDetailedBlock($this->spontaneousOrders);
        $this->generateDetailedTitle(__('reports.Voucher orders'));
        $this->generateDetailedBlock($this->voucherOrders);
        return $this->storeAndSendCsv();
    }

    /**
     * Generates title
     */
    protected function generateTotalTitle()
    {
        $this->csvData[] = [
            'Pos',
            'Menge',
            'Bezeichnung',
            'Gesamtpreis',
        ];
    }

    /**
     * @param $incomingTransactions
     * @param $manuallyBookedMoney
     * @param $orderedMeals
     * @param $spontaneousOrders
     * @param $voucherOrders
     */
    protected function generateTotalBody($incomingTransactions, $manuallyBookedMoney, $orderedMeals, $spontaneousOrders, $voucherOrders)
    {
        $this->csvData[] = [
            01,
            count($incomingTransactions['items']),
            __('reports.Incoming transactions'),
            number_format(abs($incomingTransactions['total']), 2, ',', '.'),];
        $this->csvData[] = [
            02,
            count($manuallyBookedMoney['items']),
            __('reports.Manually booked money'),
            number_format(abs($manuallyBookedMoney['total']), 2, ',', '.'),
        ];
        $this->csvData[] = [
            03,
            count($orderedMeals['items']),
            __('reports.Ordered meals'),
            number_format(abs($orderedMeals['total']), 2, ',', '.'),
        ];
        $this->csvData[] = [
            04,
            count($spontaneousOrders['items']),
            __('reports.Spontaneous orders'),
            number_format(abs($spontaneousOrders['total']), 2, ',', '.'),
        ];
        $this->csvData[] = [
            05,
            count($voucherOrders['items']),
            __('reports.Voucher orders'),
            number_format(abs($voucherOrders['total']), 2, ',', '.'),
        ];

        $this->addSeparator(2);
    }

    /**
     * @param $title
     */
    protected function generateDetailedTitle($title)
    {
        $this->csvData[] = [
            $title,
            '',
            '',
            '',
        ];
        $this->addSeparator(1);
    }

    /**
     * @param $data
     */
    protected function generateDetailedBlock($data)
    {
        $this->csvData[] = [
            'Kontonummer',
            'Kontoname',
            'Lieferdatum',
            'Buchungsdatum',
            'Betrag',
        ];

        foreach ($data['items'] as $item) {
            $this->csvData[] = [
                $item['customer_id'],
                $item['customer_name'],
                $item['delivery_date'],
                $item['posted_date'],
                number_format($item['amount'], 2, ',', '.'),
            ];
        }

        $this->addSeparator(3);
    }

    /**
     * @return mixed
     */
    protected function storeAndSendCsv()
    {
        $directory = storage_path('app/files/reports/');
        $filename  = __('reports.financial_exports') . ".csv";
        $file = $directory . $filename;

        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
        }

        $delimiter = ";";

        $f = fopen($file, 'w');
        foreach ($this->csvData as $line) {
            fputcsv($f, $line, $delimiter);
        }
        fseek($f, 0);

        $headers = [
            'Content-Type' => 'application/csv',
        ];

        return response()->download($file, $filename, $headers)->deleteFileAfterSend();
    }

    /**
     * @param int $quantity
     */
    protected function addSeparator($quantity = 1)
    {
        for ($i = 1; $i <= $quantity; $i++) {
            $this->csvData [] = ['', '', '', ''];
        }
    }
}
