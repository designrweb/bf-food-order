<?php

namespace App\Repositories;

use App\Http\Resources\CateringItemCollection;
use App\Http\Resources\CateringItemResource;
use App\CateringItem;
use App\QueryBuilders\CateringItemSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class CateringItemRepository implements RepositoryInterface
{
    /** @var CateringItem */
    protected $model;

    public function __construct(CateringItem $model)
    {
        $this->model = $model;
    }

    /**
     * @return CateringItemCollection
     */
    public function all()
    {
        return new CateringItemCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                CateringItemSearch::class,
            ])
            ->thenReturn()
            ->with('cateringCategory')
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return CateringItemResource
     */
    public function add(array $data)
    {
        return new CateringItemResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return CateringItemResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new CateringItemResource($model);
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
     * @return CateringItemResource
     */
    public function get($id)
    {
        return new CateringItemResource($this->model->with('cateringCategory')->findOrFail($id));
    }

    /**
     * @return array
     */
    public function getStatusList(): array
    {
        $statusesArray = [];
        $allStatuses   = $this->model::STATUSES;

        foreach ($allStatuses as $statusId => $statusName) {
            $statusesArray[] = [
                'id'   => $statusId,
                'name' => $statusName,
            ];
        }

        return $statusesArray;
    }
}
