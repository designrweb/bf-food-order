<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerQrCodeCollection;
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
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerQrCodeSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
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
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }
}
