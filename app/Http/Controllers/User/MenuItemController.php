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
     * @return MenuItemCollection
     */
    public function getByDate(Request $request)
    {
        return $this->service->get;
    }
}
