<?php

namespace App\Http\Controllers\api\v1\pos;

use App\ConsumerQrCode;
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
    public function store(Request $request)
    {
        $term    = $request->get('term');
        $price   = $request->get('price');
        $errors  = [];
        $message = 'Order is successfully created!';

        if (empty($term)) {
            return response()->json(['errors' => 'QR code not received!'], 422);
        }

        if (empty($price)) {
            return response()->json(['errors' => 'Price not received!'], 422);
        }

        DB::beginTransaction();

        try {
            $qrCode = ConsumerQrCode::with('consumer')
                ->where(['qr_code_hash' => $term])
                ->first();

            if (!$qrCode) {
                return response()->json(['errors' => 'Consumer not found!'], 422);
            }

            if ($qrCode->consumer->balance < $price) {
                return response()->json(['errors' => 'Consumer has not enough balance!'], 422);
            }

            $data['type']        = Order::TYPE_CASH_REGISTER;
            $data['consumer_id'] = $qrCode->consumer->id;
            $data['quantity']    = 1;
            $data['pickedup']    = 1;
            $data['day']         = date('Y-m-d');
            $data['pickedup_at'] = date('Y-m-d H:i:s');

            $this->orderService->createCashRegisterOrder($data, $price);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            $errors[] = env('APP_DEBUG') == true ? $e->getMessage() : 'Something went wrong!';

            return response()->json(['errors' => $errors], 422);
        }

        return response()->json(['message' => $message, 'success' => true]);
    }
}
