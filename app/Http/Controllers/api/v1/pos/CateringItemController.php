<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\PosTerminal\CateringItemPosTerminalCollection;
use App\Services\CateringItemService;
use Illuminate\Http\Request;

class CateringItemController extends Controller
{
    /** @var CateringItemService $service */
    protected $service;

    /**
     * CateringItemController constructor.
     *
     * @param CateringItemService $service
     */
    public function __construct(CateringItemService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request)
    {
        return CateringItemPosTerminalCollection::collection($this->service->getAllPos())->collection->groupBy('cateringCategory.name');
    }
}