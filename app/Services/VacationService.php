<?php

namespace App\Services;

use App\Http\Resources\VacationCollection;
use App\Http\Resources\VacationFormResource;
use App\Http\Resources\VacationResource;
use App\Repositories\VacationRepository;
use App\VacationLocationGroup;
use bigfood\grid\BaseModelService;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Vacation;


class VacationService extends BaseModelService
{

    protected $repository;
    /**
     * @var VacationLocationGroupService
     */
    private $groupService;
    /**
     * @var OrderService
     */
    private $orderService;

    public function __construct(VacationRepository $repository,
                                VacationLocationGroupService $groupService,
                                OrderService $orderService)
    {
        $this->repository   = $repository;
        $this->groupService = $groupService;
        $this->orderService = $orderService;
    }

    /**
     * Returns all vacation transformed to resource
     *
     * @return VacationCollection
     */
    public function all(): VacationCollection
    {
        return $this->repository->all();
    }

    /**
     * Returns single product transformed to resource
     *
     * @param $id
     * @return VacationFormResource
     * @throws ModelNotFoundException
     */
    public function getOne($id): VacationFormResource
    {
        return new VacationFormResource($this->repository->get($id));
    }

    /**
     * Creates and returns the vacation model
     *
     * @param $data
     * @return VacationResource
     * @throws \Throwable
     */
    public function create($data): VacationResource
    {
        $data['start_date'] = Carbon::createFromFormat('d.m.Y', $data['start_date'])->toDateString();
        $data['end_date']   = Carbon::createFromFormat('d.m.Y', $data['end_date'])->toDateString();

        $vacation = $this->repository->add($data);

        //save location groups
        $locationGroups = [];
        foreach ($data['location_group_id'] as $locationGroupId) {
            $locationGroups[] = [
                'vacation_id'       => $vacation->id,
                'location_group_id' => $locationGroupId
            ];
        }
        $this->groupService->createMany($locationGroups);

        if (!empty($data['with_deleting_orders'])) {
            $this->orderService->cancelOrders($data['start_date'], $data['end_date'], $data['location_group_id']);
        }

        return new VacationResource($vacation);
    }

    /**
     * Updates and returns the vacation model
     *
     * @param $data
     * @param $id
     * @return VacationResource
     * @throws ModelNotFoundException
     */
    public function update($data, $id): Vacation
    {
        $data['start_date'] = Carbon::createFromFormat('d.m.Y', $data['start_date'])->toDateString();
        $data['end_date']   = Carbon::createFromFormat('d.m.Y', $data['end_date'])->toDateString();

        $locationGroups = [];
        foreach ($data['location_group_id'] as $locationGroupId) {
            $locationGroups[] = [
                'vacation_id'       => $id,
                'location_group_id' => $locationGroupId
            ];
        }

        if (!empty($data['with_deleting_orders'])) {
            $this->orderService->cancelOrders($data['start_date'], $data['end_date'], $data['location_group_id']);
        }

        $this->groupService->createMany($locationGroups);

        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->groupService->removeByVacationId($id) && $this->repository->delete($id);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new Vacation()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new Vacation()));
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    protected function getViewFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'start_date',
                'label' => __('app.Start Date')
            ],
            [
                'key'   => 'end_date',
                'label' => __('app.End Date')
            ],
            [
                'key'   => 'location_name',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'location_group_id',
                'label' => __('location-group.Group')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return \string[][]
     */
    public function getIndexFieldsLabels(Model $model): array
    {
        return [
            [
                'key'   => 'name',
                'label' => __('app.Name')
            ],
            [
                'key'   => 'start_date',
                'label' => __('app.Start Date')
            ],
            [
                'key'   => 'end_date',
                'label' => __('app.End Date')
            ],
            [
                'key'   => 'location_name',
                'label' => __('location.Location')
            ],
            [
                'key'   => 'location_group_name',
                'label' => __('location-group.Group')
            ],
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'                => '',
            'start_date'          => '',
            'end_date'            => '',
            'location_name'       => '',
            'location_group_name' => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'                => '',
            'start_date'          => '',
            'end_date'            => '',
            'location_name'       => '',
            'location_group_name' => '',
        ];
    }
}
