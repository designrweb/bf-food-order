<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderFormRequest;
use App\Order;
use App\Services\OrderService;
use App\Services\UserService;
use Illuminate\Http\Request;

class FoodOrderController extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * Create a new controller instance.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Show the application dashboard.
     *
     * @param Request     $request
     * @param UserService $userService
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, UserService $userService)
    {
        return view('user.food_order.index', [
            'userConsumerExists' => $userService->isConsumersExists($request->user())
        ]);
    }

    /**
     * @param OrderFormRequest $request
     * @return array
     */
    public function store(OrderFormRequest $request)
    {
        $requestData = $request->get('data');
        $consumer    = $request->user()->consumer;

        $data = [
            'type'        => Order::TYPE_PRE_ORDER,
            'menuitem_id' => $requestData['id'],
            'consumer_id' => $consumer->id,
            'day'         => $requestData['availability_date'],
            'quantity'    => $requestData['quantity'],
        ];

        return [
            'order'   => $this->orderService->create($data),
            'balance' => $consumer->fresh()->balance
        ];
    }

    /**
     * @param OrderFormRequest $request
     * @return array
     */
    public function update(OrderFormRequest $request)
    {
        $requestData = $request->get('data');
        $consumer    = $request->user()->consumer;

        $data = [
            'type'        => Order::TYPE_PRE_ORDER,
            'menuitem_id' => $requestData['id'],
            'consumer_id' => $consumer->id,
            'day'         => $requestData['availability_date'],
            'quantity'    => $requestData['quantity'],
        ];

        return [
            'order'   => $this->orderService->update($data, $requestData['foodorder_id']),
            'balance' => $consumer->fresh()->balance
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function destroy(Request $request)
    {
        $this->orderService->remove($request->get('foodorder_id'));

        return [
            'balance' => $request->user()->consumer->fresh()->balance
        ];
    }
}
