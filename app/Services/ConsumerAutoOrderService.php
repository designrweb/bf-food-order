<?php
namespace App\Services;

use App\Http\Resources\ConsumerAutoOrderCollection;
use App\Http\Resources\ConsumerAutoOrderResource;
use App\Repositories\ConsumerAutoOrderRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\ConsumerAutoOrder;


class ConsumerAutoOrderService extends BaseModelService
{

    protected $repository;

    public function __construct(ConsumerAutoOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all consumer_auto_orders transformed to resource
     *
     * @return ConsumerAutoOrderCollection
     */
    public function all(): ConsumerAutoOrderCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return ConsumerAutoOrderResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): ConsumerAutoOrderResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the consumer_auto_orders model
     *
     * @param $data
     * @return ConsumerAutoOrderResource
     */
    public function create($data): ConsumerAutoOrderResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the consumer_auto_orders model
     *
     * @param $data
     * @param $id
     * @return ConsumerAutoOrderResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): ConsumerAutoOrderResource
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
        return $this->getFullStructure((new ConsumerAutoOrder()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new ConsumerAutoOrder()));
    }
}
