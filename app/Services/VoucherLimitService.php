<?php

namespace App\Services;

use App\Repositories\VoucherLimitRepository;
use bigfood\grid\BaseModelService;
use App\VoucherLimit;


class VoucherLimitService extends BaseModelService
{

    protected $repository;

    /**
     * VoucherLimitService constructor.
     *
     * @param VoucherLimitRepository $repository
     */
    public function __construct(VoucherLimitRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $data
     * @return VoucherLimit
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->repository->getList();
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
