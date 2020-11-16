<?php
namespace App\Services;

use App\Http\Resources\VoucherLimitCollection;
use App\Http\Resources\VoucherLimitResource;
use App\Repositories\VoucherLimitRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\VoucherLimit;


class VoucherLimitService extends BaseModelService
{

    protected $repository;

    public function __construct(VoucherLimitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Returns all voucher_limits transformed to resource
     *
     * @return VoucherLimitCollection
     */
    public function all(): VoucherLimitCollection
    {
         return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return VoucherLimitResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): VoucherLimitResource
    {
        return $this->repository->get($id);
    }

    /**
     * Creates and returns the voucher_limits model
     *
     * @param $data
     * @return VoucherLimitResource
     */
    public function create($data): VoucherLimitResource
    {
        return $this->repository->add($data);
    }

    /**
     * Updates and returns the voucher_limits model
     *
     * @param $data
     * @param $id
     * @return VoucherLimitResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): VoucherLimitResource
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
        return $this->getFullStructure((new VoucherLimit()));
    }

     /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new VoucherLimit()));
    }
}
