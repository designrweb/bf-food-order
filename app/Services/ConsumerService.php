<?php

namespace App\Services;

use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Repositories\ConsumerRepository;
use App\Repositories\LocationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Consumer;


class ConsumerService extends BaseModelService
{

    protected $repository;

    public function __construct(ConsumerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all consumers transformed to resource
     *
     * @return ConsumerCollection
     */
    public function all(): ConsumerCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return ConsumerResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): ConsumerResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the consumers model
     *
     * @param $data
     * @return ConsumerResource
     */
    public function create($data): ConsumerResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the consumers model
     *
     * @param $data
     * @param $id
     * @return ConsumerResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): ConsumerResource
    {
        return $this->repository->update($data, $id);
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
        $fields = [
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

        return $fields;
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
                'label' => 'Id'
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
            'id'                           => '',
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
