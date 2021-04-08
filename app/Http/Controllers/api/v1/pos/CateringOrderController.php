<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Events\CateringOrderSubmit;
use App\Http\Requests\CateringOrderFormRequest;
use App\Services\CateringOrderService;
use App\Http\Controllers\Controller;

/**
 * Class CateringOrderController
 *
 * @package App\Http\Controllers
 */
class CateringOrderController extends Controller
{

    /**
     * @var CateringOrderService
     */
    protected $service;

    /**
     * CateringOrderController constructor.
     *
     * @param CateringOrderService $service
     */
    public function __construct(CateringOrderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param CateringOrderFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CateringOrderFormRequest $request)
    {
        $message = __('order.Order is successfully created');

        try {
            $model = $this->service->create($request->all());

            event(new CateringOrderSubmit($model));
        } catch (\Exception $e) {
            return response()->json(['errors' => [$e->getMessage()]], 422);
        }

        return response()->json(['message' => $message, 'success' => true]);

    }
}
