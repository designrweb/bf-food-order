<?php

namespace App\Services;

use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Repositories\LocationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Location;


class LocationService extends BaseModelService
{

    protected $repository;

    public function __construct(LocationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all locations transformed to resource
     *
     * @return LocationCollection
     */
    public function all(): LocationCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return LocationResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): LocationResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the locations model
     *
     * @param $data
     * @return LocationResource
     */
    public function create($data): LocationResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the locations model
     *
     * @param $data
     * @param $id
     * @return LocationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): LocationResource
    {
        return $this->repository->update($data, $id);
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
        return $this->getFullStructure((new Location()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Location()));
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        $sortFields = [
            'id'         => '',
            'name'       => '',
            'image_name' => '',
        ];

        return $sortFields;
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        $fields = [
            [
                'key'   => 'image_name',
                'label' => 'Image Name'
            ],
            [
                'key'   => 'name',
                'label' => 'Name'
            ],
            [
                'key'   => 'voucher_limits',
                'label' => 'Voucher Limits'
            ],
            [
                'key'   => 'login_url',
                'label' => 'Login Url'
            ],
            [
                'key'   => 'city',
                'label' => 'City'
            ],
            [
                'key'   => 'zip',
                'label' => 'Zip'
            ],
            [
                'key'   => 'email',
                'label' => 'Email'
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
                'key'   => 'image_name',
                'label' => 'Image Name'
            ],
            [
                'key'   => 'name',
                'label' => 'Name'
            ],
            [
                'key'   => 'login_url',
                'label' => 'Login Url'
            ],
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
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }
}
