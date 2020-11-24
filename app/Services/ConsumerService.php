<?php

namespace App\Services;

use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Repositories\ConsumerRepository;
use bigfood\grid\BaseModelService;
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
}
