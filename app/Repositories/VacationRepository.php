<?php

namespace App\Repositories;

use App\Http\Resources\VacationCollection;
use App\Http\Resources\VacationResource;
use App\LocationGroup;
use App\QueryBuilders\LocationGroupSearch;
use App\Services\OrderService;
use App\Vacation;
use App\QueryBuilders\VacationSearch;
use App\VacationLocationGroup;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;
use Illuminate\Support\Facades\DB;

class VacationRepository implements RepositoryInterface
{
    /** @var Vacation */
    protected $model;

    public function __construct(Vacation $model)
    {
        $this->model = $model;
    }

    /**
     * @return VacationCollection
     */
    public function all()
    {
        return new VacationCollection(app(Pipeline::class)
            ->send($this->model->newQuery())
            ->through([
                VacationSearch::class,
            ])
            ->thenReturn()
            ->with(['locationGroups.locationGroup.location'])
            ->paginate(request('itemsPerPage') ?? 10));
    }

    /**
     * @param array $data
     * @return Vacation
     * @throws \Throwable
     */
    public function add(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param       $id
     * @return Vacation
     * @throws \Throwable
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);

        DB::beginTransaction();

        try {
            $model->update($data);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

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
     * @param       $id
     * @return Vacation|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function get($id)
    {
        return $this->model->with(['locationGroups.locationGroup.location'])->findOrFail($id);
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return VacationResource
     */
    public function getVacationByPeriod($startDate, $endDate)
    {
        return $this->model::whereBetween('start_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();
    }
}
