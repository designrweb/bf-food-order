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
     * @return VacationResource
     */
    public function add(array $data)
    {
        $model = $this->model->create($data);

        // todo move logic to service
        DB::beginTransaction();

        try {
            $model->update($data);

            $locationGroups = [];

            foreach ($data['location_group_id'] as $locationGroupId) {
                $LocationGroupModel                    = new VacationLocationGroup();
                $LocationGroupModel->location_group_id = $locationGroupId;
                $locationGroups[]                      = $LocationGroupModel;
            }

            $model->locationGroups()->delete();
            $model->locationGroups()->saveMany($locationGroups);

            if (!empty($data['with_deleting_orders'])) {
                OrderService::cancelOrders($data['start_date'], $data['end_date'], $data['location_group_id']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return new VacationResource($model);
    }

    /**
     * @param array $data
     * @param       $id
     * @return VacationResource
     */
    public function update(array $data, $id)
    {
        $model = $this->model->findOrFail($id);

        // todo move logic to service
        DB::beginTransaction();

        try {
            $model->update($data);

            $locationGroups = [];

            foreach ($data['location_group_id'] as $locationGroupId) {
                $LocationGroupModel                    = new VacationLocationGroup();
                $LocationGroupModel->location_group_id = $locationGroupId;
                $locationGroups[]                      = $LocationGroupModel;
            }

            $model->locationGroups()->delete();
            $model->locationGroups()->saveMany($locationGroups);

            if (!empty($data['with_deleting_orders'])) {
                OrderService::cancelOrders($data['start_date'], $data['end_date'], $data['location_group_id']);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return new VacationResource($model);
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
     * @return VacationResource
     */
    public function get($id)
    {
        return new VacationResource($this->model->with(['locationGroups.locationGroup.location'])->findOrFail($id));
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
