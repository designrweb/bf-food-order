<?php

namespace App\Services;

use App\Components\ImageComponent;
use App\Http\Resources\LocationResource;
use App\Repositories\LocationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\Location;
use Illuminate\Support\Facades\DB;


class LocationService extends BaseModelService
{

    /**
     * @var LocationRepository
     */
    protected $repository;

    /**
     * LocationService constructor.
     *
     * @param LocationRepository $repository
     */
    public function __construct(LocationRepository $repository)
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
     * Returns single location
     *
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
        if (!empty($data['image_name'])) {
            $data['image_name'] = ImageComponent::storeInFile($data['image_name'], Location::IMAGE_FOLDER);
        }

        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        if (!empty($data['image_name'])) {
            $data['image_name'] = ImageComponent::storeInFile($data['image_name'], Location::IMAGE_FOLDER);
        }

        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        try {
            return $this->repository->delete($id);
        } catch (\Exception $e) {
            return false;
        }
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
     * @param $data
     * @param $id
     * @return LocationResource
     */
    public function updateImage($data, $id)
    {
        $data['image_name'] = ImageComponent::storeInFile($data['image_name'], Location::IMAGE_FOLDER);

        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeImage($id)
    {
        $model              = $this->repository->getModel($id);
        $data['image_name'] = null;

        // todo move logic to service
        try {
            DB::beginTransaction();

            $this->repository->update($data, $id);
            ImageComponent::removeImage($model->imageurl, Location::IMAGE_FOLDER);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->repository->getList();
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
        return [
            'name'       => '',
            'image_name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'image_name',
                'label' => __('app.Image Name')
            ],
            [
                'key'   => 'name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'street',
                'label' => __('app.Street')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
            ],
            [
                'key'   => 'zip',
                'label' => __('app.Zip')
            ],
            [
                'key'   => 'city',
                'label' => __('app.City')
            ],
            [
                'key'   => 'email',
                'label' => __('app.Email')
            ],
            [
                'key'   => 'company.name',
                'label' => __('company.Company')
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
                'key'   => 'image_name',
                'label' => __('app.Image Name')
            ],
            [
                'key'   => 'name',
                'label' => __('app.Name')
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
