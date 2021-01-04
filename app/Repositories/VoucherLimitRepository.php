<?php

namespace App\Repositories;

use App\VoucherLimit;
use App\QueryBuilders\VoucherLimitSearch;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class VoucherLimitRepository implements RepositoryInterface
{
    /** @var VoucherLimit */
    protected $model;

    /**
     * VoucherLimitRepository constructor.
     *
     * @param VoucherLimit $model
     */
    public function __construct(VoucherLimit $model)
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
                VoucherLimitSearch::class,
            ])
            ->thenReturn()
            ->paginate(request('itemsPerPage') ?? 10);
    }

    /**
     * @param array $data
     * @return VoucherLimit
     */
    public function add(array $data)
    {
        foreach ($data as $weekday => $voucherLimit) {
            foreach ($voucherLimit as $menuId => $percentage) {
                $this->model::updateOrCreate(
                    [
                        'weekday'          => $weekday,
                        'menu_category_id' => $menuId,
                    ],
                    [
                        'percentage' => $percentage,
                    ]
                );
            }
        }

        return $this->model;
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
     */
    public function get($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        $voucherLimitsArray = [];
        $allVoucherLimits   = $this->model::all();

        foreach ($allVoucherLimits as $voucherLimit) {
            $voucherLimitsArray[$voucherLimit->weekday][$voucherLimit->menu_category_id] = $voucherLimit->percentage;
        }

        return $voucherLimitsArray;
    }
}
