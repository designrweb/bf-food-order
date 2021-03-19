<?php

namespace App\Services\Payments;

use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\Payment;

class MealOrderService extends BaseModelService
{

    protected $paymentRepository;

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }

    /**
     * Returns all payments
     *
     * @return mixed
     */
    public function all()
    {
        return $this->paymentRepository->allMealOrders();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getOne($id)
    {
        return $this->paymentRepository->get($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new Payment()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Payment()));
    }

    /**
     * @param Model $model
     * @return array[]
     */
    protected function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'consumer_account',
                'label' => __('consumer.Account')
            ],
            [
                'key'   => 'user_email',
                'label' => __('user.Email')
            ],
            [
                'key'   => 'amount_locale',
                'label' => __('app.Amount')
            ],
            [
                'key'   => 'comment',
                'label' => __('app.Comment')
            ],
            [
                'key'   => 'is_subsidized',
                'label' => __('subsidization.Is Subsidized')
            ],
            [
                'key'   => 'created_at_human',
                'label' => __('app.Created At')
            ],
            [
                'key'   => 'order_day',
                'label' => __('app.Day')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return string[]
     */
    protected function getFilters(Model $model): array
    {
        return [
            'consumer_account' => '',
            'user_email'       => '',
            'amount_locale'    => '',
            'comment'          => '',
            'is_subsidized'    => '',
            'created_at_human' => '',
            'order_day'        => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'consumer_account' => '',
            'user_email'       => '',
            'amount_locale'    => '',
            'comment'          => '',
            'is_subsidized'    => '',
            'created_at_human' => '',
            'order_day'        => '',
        ];
    }

    /**
     * @return array[]
     */
    protected function getAllowActions(): array
    {
        return [
            'all'    => false,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
        ];
    }
}
