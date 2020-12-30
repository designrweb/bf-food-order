<?php

namespace App\Services;

use App\Components\ImageComponent;
use App\Repositories\ConsumerRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\Consumer;


class ConsumerService extends BaseModelService
{

    /**
     * @var ConsumerRepository
     */
    public $repository;

    /**
     * ConsumerService constructor.
     *
     * @param ConsumerRepository $repository
     */
    public function __construct(ConsumerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
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

        $model = $this->repository->add($data);

        if (empty($model->subsidization)) {
            if ($request->hasFile('subsidization.subsidization_document')) {
                $fileName = time() . '.pdf';
                $request->file('subsidization.subsidization_document')->storeAs('subsidization_documents', $fileName, ['disk' => 'public']);
                $data['subsidization']['subsidization_document'] = $fileName;
            }
            if (!empty($data['subsidization']['subsidization_rules_id'])) {
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
            if (!empty($data['subsidization']['subsidization_rules_id'])) {
                $model->subsidization()->create($data['subsidization']);
            }
        } else {
            if ($request->hasFile('subsidization.subsidization_document')) {
                $fileName = time() . '.pdf';
                $request->file('subsidization.subsidization_document')->storeAs('subsidization_documents', $fileName, ['disk' => 'public']);
                $data['subsidization']['subsidization_document'] = $fileName;
            }
            if (!empty($data['subsidization']['subsidization_rules_id'])) {
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
        return $this->repository->generateCode($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadCode($id)
    {
        return $this->repository->downloadCode($id);
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
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'qrcode.qr_code_hash',
                'label' => 'QR Code'
            ],
            [
                'key'   => 'account_id',
                'label' => 'Account'
            ],
            [
                'key'   => 'user.email',
                'label' => 'Email'
            ],
            [
                'key'   => 'location_group.location.name',
                'label' => 'Location'
            ],
            [
                'key'   => 'birthday',
                'label' => 'Birthday'
            ],
            [
                'key'   => 'imageurl',
                'label' => 'Image'
            ],
            [
                'key'   => 'location_group.name',
                'label' => 'Group'
            ],
            [
                'key'   => 'user.user_info.first_name',
                'label' => 'Parent'
            ],
            [
                'key'   => 'balance',
                'label' => 'Balance'
            ],
            [
                'key'   => 'balance_limit',
                'label' => 'Balance limit'
            ],
            [
                'key'   => 'full_name',
                'label' => 'Child'
            ],
            [
                'key'   => 'subsidization_rule',
                'label' => 'Subsidization Rule'
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
                'label' => 'Account'
            ],
            [
                'key'   => 'user.email',
                'label' => 'Email'
            ],
            [
                'key'   => 'location_group.location.name',
                'label' => 'Location'
            ],
            [
                'key'   => 'location_group.name',
                'label' => 'Group'
            ],
            [
                'key'   => 'user.user_info.first_name',
                'label' => 'Parent'
            ],
            [
                'key'   => 'full_name',
                'label' => 'Child'
            ],
            [
                'key'   => 'subsidization_rule',
                'label' => 'Subsidization Rule'
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
            'account_id'                   => '',
            'user.email'                   => '',
            'location_group.location.name' => '',
            'location_group.name'          => '',
            'user.user_info.first_name'    => '',
            'full_name'                    => '',
            'subsidization_rule'           => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'account_id'                   => '',
            'user.email'                   => '',
            'location_group.location.name' => '',
            'location_group.name'          => '',
            'user.user_info.first_name'    => '',
            'full_name'                    => '',
            'subsidization_rule'           => '',
        ];
    }
}
