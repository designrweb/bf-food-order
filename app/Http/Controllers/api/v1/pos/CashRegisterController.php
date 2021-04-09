<?php

namespace App\Http\Controllers\api\v1\pos;

use App\ConsumerQrCode;
use App\Http\Requests\CashRegisterFormRequest;
use App\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class CashRegisterController
 *
 * @package App\Http\Controllers\api\v1\pos
 */
class CashRegisterController extends Controller
{

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * CashRegisterController constructor.
     *
     * @param OrderService $orderService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CashRegisterFormRequest $request)
    {
        $data    = $request->all();
        $message = __('order.Order is successfully created');

        DB::beginTransaction();

        try {
            $qrCode = ConsumerQrCode::with('consumer')
                ->where(['qr_code_hash' => $data['code']])
                ->first();

            if (empty($qrCode->consumer)) {
                return response()->json(['errors' => __('consumer.Consumer not found')], 422);
            }

            if ($qrCode->consumer->balance < $data['price']) {
                return response()->json(['errors' => __('app.Please increase your balance')], 422);
            }

            $data['type']        = Order::TYPE_CASH_REGISTER;
            $data['consumer_id'] = $qrCode->consumer->id;
            $data['quantity']    = 1;
            $data['pickedup']    = 1;
            $data['day']         = date('Y-m-d');
            $data['pickedup_at'] = date('Y-m-d H:i:s');

            $this->orderService->createCashRegisterOrder($data, $data['price']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['errors' => [$e->getMessage()]], 422);
        }

        return response()->json(['message' => $message, 'success' => true]);
    }
}
