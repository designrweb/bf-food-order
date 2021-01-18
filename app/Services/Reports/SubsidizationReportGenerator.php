<?php

namespace App\Services\Reports;

use App\Consumer;
use App\Order;
use App\Payment;
use App\Services\ConsumerService;
use App\Services\SubsidizationOrganizationService;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class SubsidizationReportGenerator
 *
 * @package app\services\reports
 */
class SubsidizationReportGenerator
{
    protected $csvData   = [];
    protected $tempDir   = 'app/files/reports/';
    protected $delimiter = ';';

    /** @var ConsumerService */
    protected $consumerService;

    /** @var SubsidizationOrganizationService */
    protected $subsidizationOrganizationService;

    /**
     * SubsidizationReportGenerator constructor.
     *
     * @param ConsumerService                  $consumerService
     * @param SubsidizationOrganizationService $subsidizationOrganizationService
     */
    public function __construct(ConsumerService $consumerService, SubsidizationOrganizationService $subsidizationOrganizationService)
    {
        $this->consumerService                  = $consumerService;
        $this->subsidizationOrganizationService = $subsidizationOrganizationService;
    }

    /**
     * Generate Pre Ordered Subsidization Report and send it to the user
     *
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     */
    public function generatePreOrderedSubsidizationReport($startDate, $endDate, $organizationId)
    {
        $this->fillCsvDataTitle();

        $organization = $this->subsidizationOrganizationService->getOne($organizationId);

        $consumers = $this->consumerService->getPreOrderedSubsidizationConsumers($startDate, $endDate, $organizationId);

        foreach ($consumers as $consumer) {
            $subsidizationPayments = [];

            foreach ($consumer->payments as $payment) {
                if ($payment->type === Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND) {
                    $subsidizationPayments[] = $payment;
                } else {
                    array_pop($subsidizationPayments);
                }
            }

            foreach ($subsidizationPayments as $subsidizationPayment) {
                $this->fillCsvData($subsidizationPayment->order, $consumer, $subsidizationPayment);
            }
        }

        $organizationName = $this->validateName($organization->name);

        $fileName = $organizationName . ' subsidized pre-ordered payments ' . date('d.m.Y', strtotime($startDate)) . '-' . date('d.m.Y', strtotime($endDate)) . '.csv';

        $csvFile = $this->createCsvFile($fileName);

        return response()->download($csvFile, $fileName, $this->getHeaders())->deleteFileAfterSend();
    }

    /**
     * Generate Pos Ordered Subsidization Report and send it to the user
     *
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     */
    public function generatePosOrderedSubsidizationReport($startDate, $endDate, $organizationId)
    {
        $this->fillCsvDataTitle();

        $organization = $this->subsidizationOrganizationService->getOne($organizationId);

        $consumers = $this->consumerService->getPosOrderedSubsidizationConsumers($startDate, $endDate, $organizationId);

        foreach ($consumers as $consumer) {

            foreach ($consumer->payments as $payment) {
                $this->fillCsvData($payment->order, $consumer, $payment);
            }
        }

        $organizationName = $this->validateName($organization->name);

        $fileName = $organizationName . ' subsidized pos-ordered payments ' . date('d.m.Y', strtotime($startDate)) . '-' . date('d.m.Y', strtotime($endDate)) . '.csv';

        $csvFile = $this->createCsvFile($fileName);

        return response()->download($csvFile, $fileName, $this->getHeaders())->deleteFileAfterSend();
    }

    /**
     * Fill csv data
     *
     * @param Order    $order
     * @param Consumer $consumer
     * @param Payment  $payment
     */
    protected function fillCsvData(Order $order, Consumer $consumer, Payment $payment)
    {
        $this->csvData[] = [
            !empty($order->pickedup_at)
                ? date('d.m.Y', strtotime($order->pickedup_at))
                : date('d.m.Y', strtotime($order->day)),
            date('d.m.Y', $order->created_at),
            iconv('UTF-8', 'ISO-8859-2', $consumer->lastname),
            iconv('UTF-8', 'ISO-8859-2', $consumer->firstname),
            $consumer->birthday ?? '',
            $consumer->user->location ? $consumer->user->location->name : '',
            '0,00',
            number_format($payment->amount, 2, ',', '.')
        ];
    }

    /**
     * Fill csv titles
     */
    protected function fillCsvDataTitle()
    {
        $this->csvData[] = [
            'Lieferdatum',
            'Buchungsdatum',
            'Nachname',
            'Vorname',
            'Geburtstag',
            'Schule',
            'Eigenanteil',
            'ARGE Anteil'
        ];
    }

    /**
     * @param $fileName
     * @return string
     */
    protected function createCsvFile($fileName): string
    {
        $directory = storage_path($this->tempDir);
        $file      = $directory . $fileName;

        if (!is_dir($directory)) {
            if (false === @mkdir($directory, 0777, true) && !is_dir($directory)) {
                throw new FileException(sprintf('Unable to create the "%s" directory.', $directory));
            }
        } elseif (!is_writable($directory)) {
            throw new FileException(sprintf('Unable to write in the "%s" directory.', $directory));
        }

        $f = fopen($file, 'w');
        foreach ($this->csvData as $line) {
            fputcsv($f, $line, $this->delimiter);
        }
        fseek($f, 0);

        return $file;
    }

    /**
     * @return array
     */
    protected function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/csv',
        ];
    }

    /**
     * @param $name
     * @return string
     */
    protected function validateName($name): string
    {
        return str_replace("/", '_', $name);
    }
}
