<?php

namespace App\Repositories;

use App\MenuItem;
use App\QueryBuilders\MenuItemSearch;
use Carbon\Carbon;
use Illuminate\Pipeline\Pipeline;
use bigfood\grid\RepositoryInterface;

class MenuItemRepository implements RepositoryInterface
{
    /** @var MenuItem */
    protected $model;

    public function __construct(MenuItem $model)
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
                MenuItemSearch::class,
            ])
            ->thenReturn()
            ->with(['menuCategory'])
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
     * @param array $data
     * @return mixed
     */
    public function getCountExistingMenuItems(array $data)
    {
        if (!empty($data['availability_date'])) {
            $menuItemsCount = MenuItem::whereRaw('availability_date = "' . date('Y-m-d', strtotime($data['availability_date'])) . '" ')
                ->where('menu_category_id', $data['menu_category_id']);

            if (!empty($data['id'])) {
                $menuItemsCount = $menuItemsCount->where('id', '!=', $data['id']);
            }

            return $menuItemsCount->count();
        }
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
        return $this->model->with('menuCategory')->findOrFail($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function replicate($id)
    {
        $replicated = $this->getModel($id)->replicate(['availability_date']);
        $replicated->save();

        return $replicated;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMenuItemsForPosTerminal()
    {
        return MenuItem::with('menuCategory')
            ->whereHas('menuCategory', function ($query) {
                $query->where('price', '>', 0);
            })
            ->where('availability_date', Carbon::now()->format('Y-m-d'))
            ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMenuItemsByDate()
    {
        return MenuItem::with('menuCategory')
            ->whereHas('menuCategory', function ($query) {
                $query->where('price', '>', 0);
            })
            ->where('availability_date', Carbon::now()->format('Y-m-d'))
            ->get();
    }
}
