<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\PosTerminal\HistoryPosTerminalResource;
use App\Services\OrderService;

class HistoryController extends Controller
{
    /** @var OrderService */
    private $service;

    /**
     * HistoryController constructor.
     *
     * @param OrderService $service
     */
    public function __construct(OrderService $service){
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return HistoryPosTerminalResource::collection($this->service->getOrdersForToday());
    }
}
