<?php
namespace App\Services;

use App\Http\Resources\ConsumerSubsidizationCollection;
use App\Http\Resources\ConsumerSubsidizationResource;
use App\Repositories\ConsumerSubsidizationRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\ConsumerSubsidization;


class ConsumerSubsidizationService extends BaseModelService
{

    protected $repository;

    public function __construct(ConsumerSubsidizationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all consumer_subsidizations transformed to resource
     *
     * @return ConsumerSubsidizationCollection
     */
    public function all(): ConsumerSubsidizationCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return ConsumerSubsidizationResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): ConsumerSubsidizationResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the consumer_subsidizations model
     *
     * @param $data
     * @return ConsumerSubsidizationResource
     */
    public function create($data): ConsumerSubsidizationResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the consumer_subsidizations model
     *
     * @param $data
     * @param $id
     * @return ConsumerSubsidizationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): ConsumerSubsidizationResource
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
        return $this->getFullStructure((new ConsumerSubsidization()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new ConsumerSubsidization()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removeByConsumerId($id)
    {
        return $this->repository->removeByConsumerId($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removeBySubsidizationRuleId($id)
    {
        return $this->repository->removeBySubsidizationRuleId($id);
    }
}
