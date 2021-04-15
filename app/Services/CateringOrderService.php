<?php

namespace App\Services;

use App\CateringOrder;
use App\Repositories\CateringOrderRepository;
use bigfood\grid\BaseModelService;

/**
 * Class CateringOrderService
 *
 * @package App\Services
 */
class CateringOrderService extends BaseModelService
{

    /**
     * @var CateringOrderRepository
     */
    protected $repository;

    /**
     * CateringOrderService constructor.
     *
     * @param CateringOrderRepository $repository
     */
    public function __construct(CateringOrderRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new CateringOrder()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new CateringOrder()));
    }

    /**
     * Returns allowed actions for the front-end part
     *
     * @return array
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
        ];
    }
}