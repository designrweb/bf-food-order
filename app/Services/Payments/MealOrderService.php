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
        return $this->paymentRepository->all();
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
                'label' => ucwords('account')
            ],
            [
                'key'   => 'user_email',
                'label' => ucwords('user email')
            ],
            [
                'key'   => 'amount_locale',
                'label' => ucwords('amount')
            ],
            [
                'key'   => 'comment',
                'label' => ucwords('comment')
            ],
            [
                'key'   => 'is_subsidized',
                'label' => ucwords('is subsidized')
            ],
            [
                'key'   => 'created_at_human',
                'label' => ucwords('created at')
            ],
            [
                'key'   => 'day_human',
                'label' => ucwords('day')
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
            'day_human'        => '',
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
            'day_human'        => '',
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
