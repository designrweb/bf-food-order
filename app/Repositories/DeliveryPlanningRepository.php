<?php

namespace App\Repositories;

use App\Http\Resources\DeliveryPlanningCollection;
use App\Http\Resources\DeliveryPlanningResource;
use App\DeliveryPlanning;
use App\Order;
use App\QueryBuilders\DeliveryPlanningSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class DeliveryPlanningRepository implements RepositoryInterface
{
    /** @var Order */
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    /**
     * @return DeliveryPlanningCollection
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                DeliveryPlanningSearch::class,
            ])
            ->thenReturn()
            ->with(['menuItem.menuCategory', 'consumer.locationgroup.location'])
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return DeliveryPlanningResource
     */
    public function add(array $data)
    {
        return new DeliveryPlanningResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return DeliveryPlanningResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new DeliveryPlanningResource($model);
    }

    /**
     * @param $id
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * @param       $id
     * @return DeliveryPlanningResource
     */
    public function get($id)
    {
        return new DeliveryPlanningResource($this->model->findOrFail($id));
    }
}
