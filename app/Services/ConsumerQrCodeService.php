<?php
namespace App\Services;

use App\Http\Resources\ConsumerQrCodeCollection;
use App\Http\Resources\ConsumerQrCodeResource;
use App\Repositories\ConsumerQrCodeRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\ConsumerQrCode;


class ConsumerQrCodeService extends BaseModelService
{

    protected $repository;

    public function __construct(ConsumerQrCodeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all consumer_qr_codes transformed to resource
     *
     * @return ConsumerQrCodeCollection
     */
    public function all(): ConsumerQrCodeCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return ConsumerQrCodeResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): ConsumerQrCodeResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the consumer_qr_codes model
     *
     * @param $data
     * @return ConsumerQrCodeResource
     */
    public function create($data): ConsumerQrCodeResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the consumer_qr_codes model
     *
     * @param $data
     * @param $id
     * @return ConsumerQrCodeResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): ConsumerQrCodeResource
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
        return $this->getFullStructure((new ConsumerQrCode()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new ConsumerQrCode()));
    }
}
