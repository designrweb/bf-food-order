<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Requests\OrderFormRequest;
use App\Http\Resources\OrderCollection;
use App\Order;
use App\Services\ConsumerService;
use App\Services\ExportService;
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
     * @var ConsumerService
     */
    private $consumerService;

    /**
     * Create a new controller instance.
     *
     * @param OrderService    $orderService
     * @param ConsumerService $consumerService
     */
    public function __construct(OrderService $orderService, ConsumerService $consumerService)
    {
        $this->orderService    = $orderService;
        $this->consumerService = $consumerService;
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
        $consumer    = $this->consumerService->getCurrentConsumer();

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
        $consumer    = $this->consumerService->getCurrentConsumer();

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
            'balance' => $this->consumerService->getCurrentConsumer()->fresh()->balance
        ];
    }

    /**
     * @param Request         $request
     * @param ConsumerService $consumerService
     * @param UserService     $userService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function foodOrders(Request $request, ConsumerService $consumerService, UserService $userService)
    {
        $orders             = $this->orderService->getOrdersForConsumer($consumerService->getCurrentConsumer()->id);
        $userConsumerExists = $userService->isConsumersExists($request->user());

        return view('user.food_order.orders', compact('orders', 'userConsumerExists'));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getIndexStructure(Request $request)
    {
        return $this->orderService->getIndexStructureForUser();
    }

    /**
     * @param Request         $request
     * @param ConsumerService $consumerService
     * @return array
     */
    public function getAll(Request $request, ConsumerService $consumerService)
    {
        return (new OrderCollection($this->orderService->getOrdersOverviewForConsumers($consumerService->getCurrentConsumer()->id)))->toArray($request);
    }

    /**
     * @param Request         $request
     * @param ExportService   $exportService
     * @param ConsumerService $consumerService
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, ExportService $exportService, ConsumerService $consumerService)
    {
        return $exportService->export($request, $this->orderService, false, Order::class, 'getOrdersOverviewForConsumers', ['consumerId' => $consumerService->getCurrentConsumer()->id], 'getIndexFieldsForUser');
    }
}
