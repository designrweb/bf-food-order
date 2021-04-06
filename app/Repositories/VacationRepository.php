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
        return $this->model->where('id', $id)->delete();
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
     * @param      $startDate
     * @param      $endDate
     * @param null $locationGroupId
     * @return VacationResource
     */
    public function getVacationByPeriod($startDate, $endDate, $locationGroupId = null)
    {
        $query = $this->model::where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate);

        if ($locationGroupId) {
            $query->whereHas('locationGroups', function ($q) use ($locationGroupId) {
                $q->where('vacation_location_group.location_group_id', $locationGroupId);
            });
        }

        return $query->get();
    }
}
