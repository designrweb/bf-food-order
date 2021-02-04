<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumerPosTerminalResource;
use App\Services\ConsumerService;

class ConsumerController extends Controller
{
    /** @var ConsumerService */
    private $service;

    /**
     * ConsumerController constructor.
     *
     * @param ConsumerService $service
     */
    public function __construct(ConsumerService $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return ConsumerPosTerminalResource::collection($this->service->getConsumersForPosTerminal());
    }
}
