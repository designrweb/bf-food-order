<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerQrCodeCollection;
use App\Http\Resources\ConsumerQrCodeResource;
use App\ConsumerQrCode;
use App\QueryBuilders\ConsumerQrCodeSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class ConsumerQrCodeRepository implements RepositoryInterface
{
    /** @var ConsumerQrCode */
    protected $model;

    public function __construct(ConsumerQrCode $model)
    {
        $this->model = $model;
    }

    /**
     * @return ConsumerQrCodeCollection
     */
    public function all()
    {
        return new ConsumerQrCodeCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerQrCodeSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return ConsumerQrCodeResource
     */
    public function add(array $data)
    {
        return new ConsumerQrCodeResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return ConsumerQrCodeResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new ConsumerQrCodeResource($model);
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
     * @return ConsumerQrCodeResource
     */
    public function get($id)
    {
        return new ConsumerQrCodeResource($this->model->findOrFail($id));
    }
}
