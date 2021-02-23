<?php

namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\mobile\OrderFormRequest;
use App\Http\Resources\Mobile\MobileConsumerResource;
use App\Http\Resources\Mobile\MobileOrderCollection;
use App\Services\OrderService;
use Illuminate\Http\Request;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers\api\mobile\v1
 */
class OrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $service;

    /**
     * UserController constructor.
     *
     * @param OrderService $service
     */
    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return MobileOrderCollection
     */
    public function getAll(Request $request)
    {
        return (new MobileOrderCollection($this->service->all()));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new MobileConsumerResource($this->service->getOne($id)))->toArray($request);
    }

    /**
     * @param OrderFormRequest $request
     * @return array
     */
    public function store(OrderFormRequest $request)
    {
        return (new MobileConsumerResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param OrderFormRequest    $request
     * @param                     $id
     * @return array
     */
    public function update(OrderFormRequest $request, $id)
    {
        return (new MobileConsumerResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->service->remove($id);
        } catch (\Throwable $t) {
            return response()->json(['error' => $t->getMessage()]);
        }

        return response()->json();
    }
}