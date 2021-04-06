<?php

namespace App\Repositories;

use App\CateringOrder;
use App\CateringOrderItem;
use bigfood\grid\RepositoryInterface;

/**
 * Class CateringOrderRepository
 *
 * @package App\Repositories
 */
class CateringOrderRepository implements RepositoryInterface
{

    /**
     * @var CateringOrder
     */
    protected $model;

    /**
     * CateringOrderRepository constructor.
     *
     * @param CateringOrder $model
     */
    public function __construct(CateringOrder $model)
    {
        $this->model = $model;
    }

    public function all()
    {
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
     * @return mixed
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

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        try {
            $data['user_id']    = auth('api')->user()->id;
            $model              = $this->model->create($data);
            $cateringOrderItems = [];

            foreach ($data['items'] as $id => $quantity) {
                $cateringOrderItemModel = new CateringOrderItem();

                $cateringOrderItemModel->quantity          = $quantity;
                $cateringOrderItemModel->catering_order_id = $model->id;
                $cateringOrderItemModel->catering_item_id  = $id;

                $cateringOrderItems[] = $cateringOrderItemModel;
            }

            $model->orderItems()->saveMany($cateringOrderItems);
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $model->load('orderItems');
    }
}