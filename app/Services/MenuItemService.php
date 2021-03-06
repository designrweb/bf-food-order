<?php

namespace App\Services;

use App\Repositories\MenuItemRepository;
use App\Repositories\VacationRepository;
use App\Vacation;
use bigfood\grid\BaseModelService;
use Illuminate\Database\Eloquent\Model;
use App\MenuItem;

/**
 * Class MenuItemService
 *
 * @package App\Services
 */
class MenuItemService extends BaseModelService
{

    protected $repository;
    /**
     * @var ConsumerService
     */
    private $consumerService;
    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * MenuItemService constructor.
     *
     * @param MenuItemRepository $repository
     * @param ConsumerService    $consumerService
     * @param OrderService       $orderService
     */
    public function __construct(MenuItemRepository $repository, ConsumerService $consumerService, OrderService $orderService)
    {
        $this->repository      = $repository;
        $this->consumerService = $consumerService;
        $this->orderService    = $orderService;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function getOne($id)
    {
        return $this->repository->get($id);
    }

    /**
     * @param $id
     * @return Model
     */
    public function replicate($id)
    {
        return $this->repository->replicate($id);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->repository->add($data);
    }

    /**
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        return $this->repository->update($data, $id);
    }

    /**
     * @param $id
     * @return bool
     */
    public function remove($id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getCountExistingMenuItems(array $data)
    {
        return $this->repository->getCountExistingMenuItems($data);
    }

    /**
     * @return array
     */
    public function getIndexStructure(): array
    {
        return $this->getFullStructure((new MenuItem()));
    }

    /**
     * @return array
     */
    public function getViewStructure(): array
    {
        return $this->getSimpleStructure((new MenuItem()));
    }

    /**
     * @return bool[]
     */
    protected function getAllowActions()
    {
        return [
            'all'    => true,
            'create' => true,
            'view'   => true,
            'edit'   => true,
            'delete' => false,
            'copy'   => true,
        ];
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
                'key'   => 'description',
                'label' => __('menu-item.Description')
            ],
            [
                'key'   => 'menu_category.presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => __('menu-category.Price')
            ],
            [
                'key'   => 'menu_category.name',
                'label' => __('menu-category.Menu Category')
            ],
            [
                'key'   => 'availability_date_human',
                'label' => __('menu-item.Availability Date')
            ],
            [
                'key'   => 'location.name',
                'label' => __('location.Location')
            ]
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
                'key'   => 'menu_category.presaleprice_locale',
                'label' => __('menu-category.Presale Price')
            ],
            [
                'key'   => 'menu_category.price_locale',
                'label' => __('menu-category.Price')
            ],
            [
                'key'   => 'menu_categories_name',
                'label' => __('menu-category.Menu Category')
            ],
            [
                'key'   => 'availability_date_human',
                'label' => __('menu-item.Availability Date')
            ]
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getFilters(Model $model): array
    {
        return [
            'name'                              => '',
            'menu_category.presaleprice_locale' => '',
            'menu_category.price_locale'        => '',
            'menu_categories_name'              => '',
            'availability_date_human'           => '',
        ];
    }

    /**
     * @param Model $model
     * @return array
     */
    protected function getSortFields(Model $model): array
    {
        return [
            'name'                              => '',
            'menu_category.presaleprice_locale' => '',
            'menu_category.price_locale'        => '',
            'menu_categories_name'              => '',
            'availability_date_human'           => '',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMenuItemsForPosTerminal()
    {
        return $this->repository->getMenuItemsForPosTerminal();
    }

    /**
     * @param $startDate
     * @param $endDate
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMenuItemsByDate($startDate, $endDate)
    {
        $consumer = $this->consumerService->getCurrentConsumer();

        $menuItems = $this->repository->getMenuItemsByDate($startDate, $endDate);
        $menuItems = $this->usersFoodOrdersByConsumerId($consumer->id, $menuItems);

        $vacations = (new VacationRepository((new Vacation())))
            ->getVacationByPeriod($startDate, $endDate, $consumer->location_group_id);

        return [
            'menuItems' => $menuItems->toArray(),
            'vacations' => $vacations->toArray(request())
        ];
    }

    /**
     * Get consumer orders
     *
     * @param $consumerId
     * @param $menuItems
     * @return mixed
     */
    public function usersFoodOrdersByConsumerId($consumerId, $menuItems)
    {
        $orders  = $this->orderService->getOrdersForConsumer($consumerId);
        $filters = $this->orderService->addFilters();

        foreach ($menuItems as $menuItem) {
            $order = $orders->where(['menuitem_id' => $menuItem->id] + $filters)->first();
            $menuItem->setAttribute('users_food_orders', $order);
        }

        return $menuItems;
    }
}
