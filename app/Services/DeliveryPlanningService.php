<?php

namespace App\Services;

use App\Http\Resources\DeliveryPlanningCollection;
use App\Http\Resources\DeliveryPlanningResource;
use App\Repositories\DeliveryPlanningRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Order;


class DeliveryPlanningService extends BaseModelService
{

    protected $repository;

    public function __construct(DeliveryPlanningRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return DeliveryPlanningCollection
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return DeliveryPlanningResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): DeliveryPlanningResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the delivery_planning model
     *
     * @param $data
     * @return DeliveryPlanningResource
     */
    public function create($data): DeliveryPlanningResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the delivery_planning model
     *
     * @param $data
     * @param $id
     * @return DeliveryPlanningResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): DeliveryPlanningResource
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
        return $this->getFullStructure((new Order()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Order()));
    }

    /**
     * @return false[]
     */
    protected function getAllowActions()
    {
        return [
            'all'    => false,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
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
                'key'   => 'location_name',
                'label' => 'Location'
            ],
            [
                'key'   => 'date',
                'label' => 'Date'
            ],
            [
                'key'   => 'menu_category_name',
                'label' => 'Menu Category'
            ],
            [
                'key'   => 'amount',
                'label' => 'Amount'
            ],
            [
                'key'   => 'voucher_percentage',
                'label' => 'Voucher Limits'
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
            'location_name'      => '',
            'date'               => '',
            'menu_category_name' => '',
            'amount'             => '',
            'voucher_percentage' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'location_name'      => '',
            'date'               => '',
            'menu_category_name' => '',
            'amount'             => '',
            'voucher_percentage' => '',
        ];
    }
}
