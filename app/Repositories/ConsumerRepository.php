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
     * ConsumerRepository constructor.
     *
     * @param Consumer     $model
     * @param ImageService $imageService
     */
    public function __construct(Consumer $model)
    {
        $this->model = $model;
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
        if ($data['imageurl']) {
            $data['imageurl'] = ImageService::storeImage($data['imageurl'], Consumer::IS_BASE64, Consumer::IS_ENCRYPT, Consumer::IMAGE_FOLDER);
        }

        return new ConsumerResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return ConsumerResource
     */
    public function update(array $data, $id)
    {
        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageService::storeImage($data['imageurl'], Consumer::IS_BASE64, Consumer::IS_ENCRYPT, Consumer::IMAGE_FOLDER);
        }

        $model = $this->model->findOrFail($id);
        $model->update($data);

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

    /**
     * @param array $data
     * @param       $id
     */
    public function updateImage(array $data, $id)
    {
        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageService::storeImage($data['imageurl'], Consumer::IS_BASE64, Consumer::IS_ENCRYPT, Consumer::IMAGE_FOLDER);

            $model = $this->model->findOrFail($id);
            $model->update($data);
        }

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function removeImage($id)
    {
        $model = $this->model->findOrFail($id);

        if (!Consumer::IS_BASE64) {
            ImageService::removeImage($model->imageurl, Consumer::IMAGE_FOLDER);
        }

        $model->update([
            'imageurl' => null
        ]);

        return true;
    }
}
