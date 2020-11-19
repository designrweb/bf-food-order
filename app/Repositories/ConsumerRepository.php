<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Consumer;
use App\QueryBuilders\ConsumerSearch;
use App\Services\ImageService;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class ConsumerRepository implements RepositoryInterface
{
    /** @var Consumer */
    protected $model;

    /**
     * @var ImageService
     */
    protected $imageService;

    /**
     * ConsumerRepository constructor.
     *
     * @param Consumer     $model
     * @param ImageService $imageService
     */
    public function __construct(Consumer $model, ImageService $imageService)
    {
        $this->model = $model;
        $this->imageService = $imageService;
    }

    /**
     * @return ConsumerCollection
     */
    public function all()
    {
        return new ConsumerCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return ConsumerResource
     */
    public function add(array $data)
    {
        $model = $this->model->create($data);

        $this->imageService->storeImage($data, $model);

        return new ConsumerResource($model);
    }

    /**
     * @param array $data
     * @param       $id
     * @return ConsumerResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        $this->imageService->storeImage($data, $model);

        return new ConsumerResource($model);
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
     * @return ConsumerResource
     */
    public function get($id)
    {
        return new ConsumerResource($this->model->findOrFail($id));
    }
}
