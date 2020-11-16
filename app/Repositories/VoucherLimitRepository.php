<?php

namespace App\Repositories;

use App\Http\Resources\VoucherLimitCollection;
use App\Http\Resources\VoucherLimitResource;
use App\VoucherLimit;
use App\QueryBuilders\VoucherLimitSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class VoucherLimitRepository implements RepositoryInterface
{
    /** @var VoucherLimit */
    protected $model;

    public function __construct(VoucherLimit $model)
    {
        $this->model = $model;
    }

    /**
     * @return VoucherLimitCollection
     */
    public function all()
    {
        return new VoucherLimitCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                VoucherLimitSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return VoucherLimitResource
     */
    public function add(array $data)
    {
        return new VoucherLimitResource($this->model->create($data));
    }

    /**
     * @param array $data
     * @param       $id
     * @return VoucherLimitResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return new VoucherLimitResource($model);
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
     * @return VoucherLimitResource
     */
    public function get($id)
    {
        return new VoucherLimitResource($this->model->findOrFail($id));
    }
}
