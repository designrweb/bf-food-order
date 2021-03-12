<?php

namespace App\Services;

use App\Components\ImageComponent;
use App\Repositories\ConsumerRepository;
use bigfood\grid\BaseModelService;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Database\Eloquent\Model;
use App\Consumer;
use Mpdf\Mpdf;
use PDF;


class ConsumerService extends BaseModelService
{
    /**
     * @var ConsumerRepository
     */
    public $repository;
    /**
     * @var ConsumerQrCodeService
     */
    public $qrCodeService;

    /**
     * ConsumerService constructor.
     *
     * @param ConsumerRepository       $repository
     * @param ConsumerQrCodeService $consumerQrCodeService
     */
    public function __construct(ConsumerRepository $repository, ConsumerQrCodeService $consumerQrCodeService)
    {
        $this->repository    = $repository;
        $this->qrCodeService = $consumerQrCodeService;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function allByUserId($userId)
    {
        return $this->repository->allByUserId($userId);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getOneByAccountId($accountId)
    {
        return $this->repository->getByAccountId($accountId);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->repository->getList();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function create($request)
    {
        $data = $request->all();

        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageComponent::storeEncrypt($data['imageurl']);
        }

        $data['account_id'] = $this->generateAccountId();

        $model = $this->repository->add($data);

        $this->generateCode($model->id);

        if (empty($model->subsidization)) {
            if ($request->hasFile('subsidization.subsidization_document')) {
                $fileName = time() . '.pdf';
                $request->file('subsidization.subsidization_document')->storeAs('subsidization_documents', $fileName, ['disk' => 'public']);
                $data['subsidization']['subsidization_document'] = $fileName;
            }
            if (!empty($data['subsidization']['subsidization_rule_id'])) {
                $model->subsidization()->create($data['subsidization']);
            }
        }

        return $model;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $data = $request->all();

        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageComponent::storeEncrypt($data['imageurl']);
        }

        $model = $this->repository->update($data, $id);

        if (empty($model->subsidization)) {
            if ($request->hasFile('subsidization.subsidization_document')) {
                $fileName = time() . '.pdf';
                $request->file('subsidization.subsidization_document')->storeAs('subsidization_documents', $fileName, ['disk' => 'public']);
                $data['subsidization']['subsidization_document'] = $fileName;
            }
            if (!empty($data['subsidization']['subsidization_rule_id'])) {
                $model->subsidization()->create($data['subsidization']);
            }
        } else {
            if ($request->hasFile('subsidization.subsidization_document')) {
                $fileName = time() . '.pdf';
                $request->file('subsidization.subsidization_document')->storeAs('subsidization_documents', $fileName, ['disk' => 'public']);
                $data['subsidization']['subsidization_document'] = $fileName;
            }
            if (!empty($data['subsidization']['subsidization_rule_id'])) {
                $model->subsidization->update($data['subsidization']);
            }
        }

        return $model;
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function generateCode($id)
    {
        $codeHash = bin2hex(random_bytes(32));

        return $this->repository->generateCode($id, $codeHash);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadCode($id)
    {
        $model = $this->getOne($id);

        return QRService::codeToImage($model->qrCode->qr_code_hash);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Throwable
     */
    public function downloadManual($id)
    {
        $model = $this->repository->get($id);
        $qrCodeImage = $this->getQrCodeImage($id);
        $view = view('consumers.manual', compact('model', 'qrCodeImage'))->render();

        $mpdf = new Mpdf();
        $mpdf->WriteHTML($view);

        return $mpdf->Output('', 'I');
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new Consumer()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Consumer()));
    }

    /**
     * @param $model
     * @return array
     */
    public function getIndexStructureForUser($model): array
    {
        return [
            'filters'      => $this->getFilters($model),
            'sort'         => $this->getSortFields($model),
            'fields'       => $this->getIndexFieldsLabels($model),
            'allowActions' => $this->getAllowActionsForUser(),
        ];
    }

    /**
     * @return array
     */
    public function getViewStructureForUser(): array
    {
        return $this->getSimpleStructureForUser((new Consumer()));
    }

    /**
     * @param $data
     * @param $id
     * @return bool
     */
    public function updateImage($data, $id)
    {
        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageComponent::storeEncrypt($data['imageurl']);
        }

        return $this->repository->updateImage($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeImage($id)
    {
        return $this->repository->removeImage($id);
    }

    /**
     * Get all consumers that made preordered payments with organization subsidization within date range
     *
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     * @return mixed
     */
    public function getPreOrderedSubsidizationConsumers($startDate, $endDate, $organizationId)
    {
        $startDate = $this->startOfDay($startDate);
        $endDate   = $this->endOfDay($endDate);

        return $this->repository->getPreOrderedSubsidizationConsumers($startDate, $endDate, $organizationId);
    }

    /**
     * Get all consumers that made pos ordered payments with organization subsidization within date range
     *
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     * @return Consumer[]|array
     */
    public function getPosOrderedSubsidizationConsumers($startDate, $endDate, $organizationId)
    {
        $startDate = $this->startOfDay($startDate);
        $endDate   = $this->endOfDay($endDate);

        return $this->repository->getPosOrderedSubsidizationConsumers($startDate, $endDate, $organizationId);
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'account_id',
                'label' => __('consumer.Account')
            ],
            [
                'key'   => 'user.email',
                'label' => __('app.Email')
            ],
            [
                'key'   => 'location_group.location.name',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'birthday',
                'label' => __('consumer.Birthday')
            ],
            [
                'key'   => 'imageurl',
                'label' => __('app.Image Name')
            ],
            [
                'key'   => 'location_group.name',
                'label' => __('location-group.Group')
            ],
            [
                'key'   => 'user.user_info.first_name',
                'label' => __('consumer.Parent')
            ],
            [
                'key'   => 'balance',
                'label' => __('consumer.Balance')
            ],
            [
                'key'   => 'balance_limit',
                'label' => __('consumer.Balance limit')
            ],
            [
                'key'   => 'full_name',
                'label' => __('consumer.Child')
            ],
            [
                'key'   => 'subsidization.subsidization_rule.rule_name',
                'label' => __('subsidization.Subsidization Rule')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'id',
                'label' => '#'
            ],
            [
                'key'   => 'account_id',
                'label' => __('consumer.Account')
            ],
            [
                'key'   => 'user.email',
                'label' => __('app.Email')
            ],
            [
                'key'   => 'location_group.location.name',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'location_group.name',
                'label' => __('location-group.Group')
            ],
            [
                'key'   => 'user.user_info.first_name',
                'label' => __('consumer.Parent')
            ],
            [
                'key'   => 'full_name',
                'label' => __('consumer.Child')
            ],
            [
                'key'   => 'subsidization.subsidization_rule.rule_name',
                'label' => __('subsidization.Subsidization Rule')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return string[]
     */
    protected function getFilters(Model $model): array
    {
        return [
            'account_id'                                 => '',
            'user.email'                                 => '',
            'location_group.location.name'               => '',
            'location_group.name'                        => '',
            'user.user_info.first_name'                  => '',
            'full_name'                                  => '',
            'subsidization.subsidization_rule.rule_name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'account_id'                                 => '',
            'user.email'                                 => '',
            'location_group.location.name'               => '',
            'location_group.name'                        => '',
            'user.user_info.first_name'                  => '',
            'full_name'                                  => '',
            'subsidization.subsidization_rule.rule_name' => '',
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => auth()->user()->can('create', Consumer::class),
            'view'   => true,
            'edit'   => auth()->user()->can('create', Consumer::class),
            'delete' => false,
        ];
    }

    /**
     * Returns allowed actions for the front-end part
     * for user role
     *
     * @return array
     */
    protected function getAllowActionsForUser()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => auth()->user()->can('create', Consumer::class),
            'delete' => true,
        ];
    }

    /**
     * Convert Date to the start of the day
     *
     * @param $date
     * @return false|string
     */
    protected function startOfDay($date)
    {
        return date('Y-m-d H:i:s', strtotime('midnight', strtotime($date)));
    }

    /**
     * Convert Date to the end of the day
     *
     * @param $date
     * @return false|string
     */
    protected function endOfDay($date)
    {
        return date('Y-m-d H:i:s', strtotime("tomorrow", strtotime($date)) - 1);
    }

    /**
     * Generate unique account id that contains 6 digits
     */
    protected function generateAccountId(): string
    {
        $accounts = $this->repository->getAccountIdList();

        $accountId = strval(rand(100000, 999999));

        while ($accounts->contains($accountId)) {
            $accountId = strval(rand(100000, 999999));
        }

        return $accountId;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getConsumersForPosTerminal()
    {
        return $this->repository->getConsumersForPosTerminal();
    }


    /**
     * Generate base64 image from qr code hash
     *
     * @param $id
     * @return string|null
     */
    public function getQrCodeImage($id)
    {
        if (!$qrCodeModel = $this->repository->get($id)->qrCode) return null;

        $options = new QROptions([
            'outputType'     => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'       => QRCode::ECC_H,
            'pngCompression' => -1,
            'scale'          => 10

        ]);

        $q        = new QRCode($options);
        $tmpFile = tempnam(sys_get_temp_dir(), 'qr');

        return $q->render($qrCodeModel->qr_code_hash, $tmpFile);
    }

    /**
     * Get support Subsidization email by consumer id
     *
     * @param $id
     * @return string|null
     */
    public function getSubsidizationSupportEmail($id)
    {
        $setting = $this->repository->getSubsidizationSupportEmail($id);

        return $setting ? $setting->value : null;
    }
}
