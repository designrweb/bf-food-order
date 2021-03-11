<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemCollection;
use App\Http\Resources\MenuItemResource;
use App\Services\MenuItemService;
use App\Services\MenuCategoryService;
use App\Http\Requests\MenuItemFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MenuItemController
 *
 * @package App\Http\Controllers
 */
class MenuItemController extends Controller
{
    /** @var MenuItemService $service */
    protected $service;

    public function __construct(MenuItemService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return MenuItemCollection|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMenuItems(Request $request)
    {
        $startDate = $request->query('start_date', false);
        $endDate = $request->query('end_date', false);

        return $this->service->getMenuItemsByDate($startDate, $endDate);
    }
}
