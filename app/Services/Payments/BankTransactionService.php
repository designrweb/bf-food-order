<?php

namespace App\Services\Payments;

use App\Repositories\PaymentRepository;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\Payment;

class BankTransactionService extends BaseModelService
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
                'key'   => 'created_at_human',
                'label' => ucwords('created at')
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
            'created_at_human' => '',
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
            'created_at_human' => '',
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
