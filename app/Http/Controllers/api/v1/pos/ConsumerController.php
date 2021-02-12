<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Consumer;
use App\ConsumerQrCode;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumerPosTerminalResource;
use App\Services\ConsumerService;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function searchByConsumer(Request $request)
    {
        $term = $request->get('term');

        if (empty($term)) return [];

        $consumers = Consumer::where('firstname', 'like', '%' . $term . '%')
            ->orWhere('lastname', 'like', '%' . $term . '%')
            ->get();

        return ConsumerPosTerminalResource::collection($consumers);
    }

    /**
     * @param Request $request
     * @return ConsumerPosTerminalResource|array
     */
    public function searchByQrCode(Request $request)
    {
        $term = $request->get('term');

        if (empty($term)) return [];

        $qrCode = ConsumerQrCode::with('consumer')
            ->where(['qr_code_hash' => $term])
            ->first();

        if (!$qrCode) return [];

        return new ConsumerPosTerminalResource($qrCode->consumer);
    }
}
