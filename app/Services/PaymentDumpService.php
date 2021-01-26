<?php

namespace App\Services;

use App\Payment;
use App\Repositories\PaymentDumpRepository;
use bigfood\grid\BaseModelService;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use App\PaymentDump;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Csv;


class PaymentDumpService extends BaseModelService
{
    /**
     * @var PaymentDumpRepository
     */
    protected $repository;
    /**
     * @var ConsumerService
     */
    private $consumerService;
    /**
     * @var PaymentService
     */
    private $paymentService;

    const STORAGE_FILE_PATH = 'files/payment-dumps';

    const COL_TYPE       = 'Buchungstext';
    const COL_DATE       = 'Valutadatum';
    const COL_AMOUNT     = 'Betrag';
    const COL_COMMENT    = 'Verwendungszweck';
    const COL_ACCOUNT_ID = 'Kundenreferenz (End-to-End)';

    const STATUS_UPLOADED   = 0;
    const STATUS_PROCESSED  = 1;
    const STATUS_DUPLICATED = 2;

    const NEEDED_PAYMENT_TYPE = 'GUTSCHR. UEBERWEISUNG';

    const STATUSES = [
        self::STATUS_UPLOADED   => 'UPLOADED',
        self::STATUS_PROCESSED  => 'PROCESSED',
        self::STATUS_DUPLICATED => 'DUPLICATED',
    ];

    public function __construct(PaymentDumpRepository $repository, ConsumerService $consumerService, PaymentService $paymentService)
    {
        $this->repository      = $repository;
        $this->consumerService = $consumerService;
        $this->paymentService  = $paymentService;
    }

    /**
     * Returns all payment dumps
     *
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Returns single payment dump
     *
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the payment dumps model
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the payment dumps model
     *
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $file
     * @return array
     */
    public function uploadFile($file)
    {
        $fileName = $file->getClientOriginalName();
        $folder   = self::STORAGE_FILE_PATH;

        try {
            Storage::putFileAs($folder, $file, $fileName);

            return ['status' => 'success', 'fileName' => $fileName, 'message' => 'Payment CSV-dump has been uploaded successfully'];

        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * @param $id
     * @return array|array[]
     */
    public function parse($id)
    {
        $dump     = $this->getOne($id);
        $filePath = Storage::path(self::STORAGE_FILE_PATH . DIRECTORY_SEPARATOR . $dump->file_name);
        $reader   = new Csv();
        $reader->setInputEncoding("ISO-8859-2");
        $reader->setDelimiter(';');
        $reader->setSheetIndex(0);
        $spreadsheet       = $reader->load($filePath);
        $activeSpreadsheet = $spreadsheet->getActiveSheet();
        $csv               = $activeSpreadsheet->toArray();
        $header            = array_flip($csv[0]);
        unset($csv[0]);

        return array_map(function ($payment) use ($header) {
            return [
                'account_id'    => $payment[$header[self::COL_ACCOUNT_ID]],
                'type'          => $payment[$header[self::COL_TYPE]],
                'date'          => $payment[$header[self::COL_DATE]],
                'amount'        => $payment[$header[self::COL_AMOUNT]] ? floatval(str_replace(',', '.', $payment[$header[self::COL_AMOUNT]])) : null,
                'comment'       => $payment[$header[self::COL_COMMENT]],
                'transacted_at' => $payment[$header[self::COL_DATE]]
                    ? (DateTime::createFromFormat('d.m.y', $payment[$header[self::COL_DATE]]))->format('Y-m-d')
                    : null,
            ];
        }, $csv);
    }

    /**
     * @param array $parsed_dump
     * @return false
     */
    public function fillPayments(array $parsed_dump)
    {
        if (empty($parsed_dump)) return false;

        foreach ($parsed_dump as $payment) {
            preg_match('/([0-9]{6})/', $payment['comment'], $matches);

            $accountId = key_exists(1, $matches) ? $matches[1] : null;

            $consumer = $this->consumerService->getOneByAccountId($accountId);

            if ($consumer) {
                $payment_record = Payment::where([
                    'transacted_at' => $payment['transacted_at'],
                    'consumer_id'   => $consumer->consumer_id,
                    'amount'        => $payment['amount']
                ])->first();
            } else {
                $payment_record = Payment::where([
                    'transacted_at' => $payment['transacted_at'],
                    'comment'       => $payment['comment'],
                    'amount'        => $payment['amount']
                ])->first();
            }
            if ($payment_record) continue;

            $payment_record = [
                'amount'        => $payment['amount'],
                'type'          => Payment::TYPE_BANK_TRANSACTION,
                'comment'       => $payment['comment'],
                'consumer_id'   => $consumer ? $consumer->consumer_id : null,
                'transacted_at' => $payment['transacted_at'],
            ];

            $this->paymentService->create($payment_record);
        }
    }

    /**
     * @param $id
     */
    public function markAsProcessed($id)
    {
        $this->update(['status' => self::STATUS_PROCESSED], $id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new PaymentDump()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new PaymentDump()));
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->repository->getList();
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'file_name'    => '',
            'status'       => [
                'values' => $this->repository->getList(),
                'filter' => '',
                'type'   => 'select',
            ],
            'created_at'   => '',
            'updated_at'   => '',
            'requested_at' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'file_name'    => '',
            'status'       => '',
            'created_at'   => '',
            'updated_at'   => '',
            'requested_at' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'file_name',
                'label' => __('payment-dump.File Name')
            ],
            [
                'key'   => 'status',
                'label' => __('app.Status')
            ],
            [
                'key'   => 'requested_at',
                'label' => __('payment-dump.Requested At')
            ],
            [
                'key'   => 'created_at',
                'label' => __('payment-dump.Uploaded At')
            ],
            [
                'key'   => 'updated_at',
                'label' => __('payment-dump.Processed At')
            ],
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions(): array
    {
        return [
            'all'    => false,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
        ];
    }
}
