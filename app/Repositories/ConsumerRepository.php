<?php

namespace App\Repositories;

use App\Consumer;
use App\Payment;
use App\QueryBuilders\ConsumerSearch;
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
     * @param Consumer $model
     */
    public function __construct(Consumer $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                ConsumerSearch::class,
            ])
            ->thenReturn()
            ->with(['user.userInfo', 'locationGroup.location', 'subsidization.subsidizationRule'])
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        return $this->model->create($data);
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
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function get($id)
    {
        return $this->getModel($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getModel($id)
    {
        return $this->model->with(['user.userInfo', 'locationGroup.location', 'qrcode', 'subsidization.subsidizationRule.subsidizationOrganization'])->findOrFail($id);
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
        $model = $this->model->findOrFail($id);

        return $model->update($data);
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

    /**
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPreOrderedSubsidizationConsumers($startDate, $endDate, $organizationId)
    {
        return Consumer::with([
            'payments' => function ($query) use ($startDate, $endDate, $organizationId) {
                $query->where(function ($query) {
                    $query->where('payments.type', Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND)
                        ->orWhere('payments.type', Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND);
                })
                    ->whereBetween('payments.created_at', [strtotime($startDate), strtotime($endDate)])
                    ->whereNotNull('payments.order_id')
                    ->where('subsidization_organization_id', $organizationId)
                    ->orderBy('payments.id', 'asc')
                    ->join('orders', 'payments.order_id', '=', 'orders.id');
            }
        ])
            ->get();
    }

    /**
     * @param $startDate
     * @param $endDate
     * @param $organizationId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getPosOrderedSubsidizationConsumers($startDate, $endDate, $organizationId)
    {
        return Consumer::with([
            'payments' => function ($query) use ($startDate, $endDate, $organizationId) {
                $query->where(function ($query) {
                    $query->where('payments.type', Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND);
                })
                    ->whereBetween('payments.created_at', [strtotime($startDate), strtotime($endDate)])
                    ->whereNotNull('payments.order_id')
                    ->where('subsidization_organization_id', $organizationId)
                    ->orderBy('payments.id', 'asc')
                    ->join('orders', 'payments.order_id', '=', 'orders.id');
            }
        ])
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getAccountIdList(): \Illuminate\Support\Collection
    {
        return $this->model->all()->pluck('account_id');
    }
}
