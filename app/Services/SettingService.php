<?php

namespace App\Services;

use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Repositories\SettingRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Setting;


class SettingService extends BaseModelService
{

    protected $repository;

    public function __construct(SettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all settings transformed to resource
     *
     * @return SettingCollection
     */
    public function all(): SettingCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return SettingResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): SettingResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the settings model
     *
     * @param $data
     * @return SettingResource
     */
    public function create($data): SettingResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the settings model
     *
     * @param $data
     * @param $id
     * @return SettingResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): SettingResource
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
        return $this->getFullStructure((new Setting()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Setting()));
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'setting_name',
                'label' => 'Setting Name'
            ],
            [
                'key'   => 'visible_name',
                'label' => 'Visible Name'
            ],
            [
                'key'   => 'value',
                'label' => 'Value'
            ]
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
                'key'   => 'setting_name',
                'label' => 'Setting Name'
            ],
            [
                'key'   => 'visible_name',
                'label' => 'Visible Name'
            ],
            [
                'key'   => 'value',
                'label' => 'Value'
            ]
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'setting_name' => '',
            'visible_name' => '',
            'value'        => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'id'           => '',
            'setting_name' => '',
            'visible_name' => '',
            'value'        => '',
        ];
    }
}
