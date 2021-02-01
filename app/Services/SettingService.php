<?php

namespace App\Services;

use App\Http\Resources\CombinedSettingCollection;
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

    /**
     * SettingService constructor.
     *
     * @param SettingRepository $repository
     */
    public function __construct(SettingRepository $repository)
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
     * @return mixed
     */
    public function allCombined()
    {
        return $this->repository->allCombined();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @return bool
     */
    public function combinedUpdate($data)
    {
        $this->repository->updateLogo($data['logo'] ?? null);
        $this->repository->updateThemeColor($data['theme_color'] ?? null);
        $this->repository->updateSidebarColor($data['sidebar_theme_color'] ?? null);
        $this->repository->updateEmail($data['email'] ?? null);

        return true;
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
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
                'label' => __('setting.Setting Name')
            ],
            [
                'key'   => 'visible_name',
                'label' => __('setting.Visible Name')
            ],
            [
                'key'   => 'value',
                'label' => __('setting.Value')
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
                'label' => __('setting.Setting Name')
            ],
            [
                'key'   => 'visible_name',
                'label' => __('setting.Visible Name')
            ],
            [
                'key'   => 'value',
                'label' => __('setting.Value')
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
