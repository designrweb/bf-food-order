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
    public function getIndexStructureForUser(): array
    {
        return $this->getFullStructureForUser((new Payment()));
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
                'label' => __('payment.Amount')
            ],
            [
                'key'   => 'comment',
                'label' => __('app.Comment')
            ],
            [
                'key'   => 'created_at_human',
                'label' => __('app.Created At')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array[]
     */
    protected function getIndexFieldsForUser(Model $model): array
    {
        return [
            [
                'key'   => 'amount_locale',
                'label' => __('payment.Amount')
            ],
            [
                'key'   => 'comment',
                'label' => __('app.Comment')
            ],
            [
                'key'   => 'created_at_human',
                'label' => __('app.Created At')
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
     * @return string[]
     */
    protected function getFiltersForUser(Model $model): array
    {
        return [
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
     * @param Model $model
     * @return array
     */
    protected function getSortFieldsForUser(Model $model): array
    {
        return [
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
            'all'    => true,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
        ];
    }

    /**
     * @return array[]
     */
    protected function getAllowActionsForUser(): array
    {
        return [
            'all'    => false,
            'create' => false,
            'view'   => false,
            'edit'   => false,
            'delete' => false,
        ];
    }

    /**
     * Returns main model full structure
     *
     * @param Model $model
     * @return array
     */
    public function getFullStructureForUser(Model $model): array
    {
        return [
            'filters'      => $this->getFiltersForUser($model),
            'sort'         => $this->getSortFieldsForUser($model),
            'fields'       => $this->getIndexFieldsForUser($model),
            'allowActions' => $this->getAllowActionsForUser(),
        ];
    }
}
