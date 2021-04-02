<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerSubsidizationCollection;
use App\Http\Resources\ConsumerSubsidizationResource;
use App\ConsumerSubsidization;
use App\QueryBuilders\ConsumerSubsidizationSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class ConsumerSubsidizationRepository implements RepositoryInterface
{
    /** @var ConsumerSubsidization */
    protected $model;

    public function __construct(ConsumerSubsidization $model)
    {
        $this->model = $model;
    }

    /**
     * @return ConsumerSubsidizationCollection
     */
    public function all()
    {
        return new ConsumerSubsidizationCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerSubsidizationSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return ConsumerSubsidizationResource
     */
    public function add(array $data)
    {
        return new ConsumerSubsidizationResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return ConsumerSubsidizationResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new ConsumerSubsidizationResource($model);
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
     * @return ConsumerSubsidizationResource
     */
    public function get($id)
    {
        return new ConsumerSubsidizationResource($this->model->findOrFail($id));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removeByConsumerId($id)
    {
        return $this->model->where('consumer_id', $id)->delete();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function removeBySubsidizationRuleId($id)
    {
        return $this->model->where('subsidization_rule_id', $id)->delete();
    }
}
