<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemPosTerminalResource;
use App\Services\MenuItemService;

class MenuItemController extends Controller
{
    /** @var MenuItemService */
    private $service;

    /**
     * MenuItemController constructor.
     *
     * @param MenuItemService $service
     */
    public function __construct(MenuItemService $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return MenuItemPosTerminalResource::collection($this->service->getMenuItemsForPosTerminal());
    }
}
