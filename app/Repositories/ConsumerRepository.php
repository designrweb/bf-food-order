<?php

namespace App\Repositories;

use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Consumer;
use App\QueryBuilders\ConsumerSearch;
use App\Services\ImageService;
use App\Services\QRService;
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
            ->with(['user.userInfo', 'locationGroup.location'])
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return ConsumerResource
     */
    public function add(array $data)
    {
        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageService::storeEncrypt($data['imageurl']);
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
            $data['imageurl'] = ImageService::storeEncrypt($data['imageurl']);
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
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function generateCode($id)
    {
        $model    = $this->model->findOrFail($id);
        $codeHash = bin2hex(random_bytes(32));

        if (empty($model->qrcode)) {
            $model->qrcode()->create([
                'qr_code_hash' => $codeHash
            ]);
        } else {
            $model->qrcode->update([
                'qr_code_hash' => $codeHash
            ]);
        }

        return $model->load('qrcode');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadCode($id)
    {
        $model = $this->getModel($id);

        return QRService::codeToImage($model->qrcode->qr_code_hash);
    }

    /**
     * @param       $id
     * @return ConsumerResource
     */
    public function get($id)
    {
        return new ConsumerResource($this->getModel($id));
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getModel($id)
    {
        return $this->model->with(['user.userInfo', 'locationGroup.location', 'qrcode'])->findOrFail($id);
    }

    /**
     * @param $accountId
     * @return mixed
     */
    public function getByAccountId($accountId)
    {
        return $this->model::where('account_id', $accountId)->first();
    }

    /**
     * @return array
     */
    public function getList()
    {
        $consumersArray = [];
        $allConsumers   = $this->model::all();

        foreach ($allConsumers as $consumer) {
            $consumersArray[] = [
                'id'   => $consumer->id,
                'name' => sprintf('%s-%s %s', $consumer->account_id, $consumer->lastname, $consumer->firstname)
            ];
        }

        return $consumersArray;
    }

    /**
     * @param array $data
     * @param       $id
     */
    public function updateImage(array $data, $id)
    {
        if (!empty($data['imageurl'])) {
            $data['imageurl'] = ImageService::storeEncrypt($data['imageurl']);

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

        $model->update([
            'imageurl' => null
        ]);

        return true;
    }
}
