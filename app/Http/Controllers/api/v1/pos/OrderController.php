<?php

namespace App\Http\Controllers\api\v1\pos;

use App\Http\Controllers\Controller;
use App\MenuCategory;
use App\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /** @var OrderService */
    private $orderService;

    /**
     * OrderController constructor.
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
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        $data   = $request->all();
        $errors = [];

        DB::beginTransaction();
        try {
            foreach ($data as $item) {

                // create order with type voucher
                if ($this->isVoucherOrder($item)) {
                    $voucherOrder['menuitem_id'] = $item['menuitem_id'];
                    $voucherOrder['type']        = $item['type'];
                    $voucherOrder['quantity']    = $item['quantity'];
                    $voucherOrder['pickedup']    = 1;
                    $voucherOrder['day']         = date('Y-m-d');
                    $voucherOrder['pickedup_at'] = date('Y-m-d H:i:s');

                    $this->orderService->create($voucherOrder);
                }

                // create order with type preordered
                if ($this->isPreOrder($item)) {
                    $order = Order::where(['type' => Order::TYPE_PRE_ORDER])
                        ->where(['menuitem_id' => $item['menuitem_id']])
                        ->where(['consumer_id' => $item['consumer_id']])
                        ->where(['pickedup' => 0])
                        ->where(['day' => date('Y-m-d')])
                        ->first();

                    $this->orderService->update([
                        'pickedup'    => 1,
                        'pickedup_at' => date('Y-m-d H:i:s')
                    ], $order->id);
                }

                // create spontaneous order
                if ($this->isPosOrder($item)) {
                    $posOrder['menuitem_id']   = $item['menuitem_id'];
                    $posOrder['type']          = $item['type'];
                    $posOrder['quantity']      = $item['quantity'];
                    $posOrder['consumer_id']   = $item['consumer_id'];
                    $posOrder['pickedup']      = 1;
                    $posOrder['day']           = date('Y-m-d');
                    $posOrder['pickedup_at']   = date('Y-m-d H:i:s');
                    $posOrder['is_subsidized'] = isset($item['is_subsidized']) ? $item['is_subsidized'] : 0;

                    $this->orderService->create($posOrder);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['errors' => $errors], 422);
        }

        return response()->json(['message' => 'Order is successfully created']);
    }

    /**
     * @return array
     */
    public function limit(): array
    {
        $orders = Order::with('menuItem')
            ->where('type', Order::TYPE_PRE_ORDER)
            ->where(function ($query) {
                $query->where('day', date('Y-m-d'))
                    ->orWhere('pickedup_at', 'like', date('Y-m-d') . '%');
            })
            ->get();

        // todo add $voucherLimit
//        $voucherLimit = Location::select('voucher_limit')
//            ->first();

        return [
            'orders'       => $orders,
            'voucherLimit' => 0
        ];

    }

    /**
     * @return array
     */
    public function statistic(): array
    {
        $date = request()->get('date');

        if (empty($date)) return [];

        $result = MenuCategory::join('menu_items', 'menu_categories.id', 'menu_items.menu_category_id')
            ->join('orders', 'menu_items.id', 'orders.menuitem_id')
            ->select([
                'menu_categories.id AS menuCategoryId',
                'menu_categories.name AS menuCategoryName',
                'orders.type AS orderType',
                DB::raw('SUM(orders.quantity) as quantity')
            ])
            ->where(['day' => date('Y-m-d', strtotime($date))])
            ->orderBy('category_order')
            ->groupBy('menuCategoryId', 'menuCategoryName', 'orderType')
            ->get()
            ->toArray();

        $menuCategories = [];

        foreach ($result as $menuCategory) {
            $menuCategories[$menuCategory['menuCategoryId']]['menuCategoryName'] = $menuCategory['menuCategoryName'];

            if ($menuCategory['orderType'] == 1) {
                $menuCategories[$menuCategory['menuCategoryId']]['preOrders'] = $menuCategory['quantity'];
            } else if (!isset($menuCategories[$menuCategory['menuCategoryId']]['preOrders'])) {
                $menuCategories[$menuCategory['menuCategoryId']]['preOrders'] = 0;
            }

            if ($menuCategory['orderType'] == 2) {
                $menuCategories[$menuCategory['menuCategoryId']]['posOrders'] = $menuCategory['quantity'];
            } else if (!isset($menuCategories[$menuCategory['menuCategoryId']]['posOrders'])) {
                $menuCategories[$menuCategory['menuCategoryId']]['posOrders'] = 0;
            }

            if ($menuCategory['orderType'] == 3) {
                $menuCategories[$menuCategory['menuCategoryId']]['vouchers'] = $menuCategory['quantity'];
            } else if (!isset($menuCategories[$menuCategory['menuCategoryId']]['vouchers'])) {
                $menuCategories[$menuCategory['menuCategoryId']]['vouchers'] = 0;
            }
        }

        return [
            'orders' => $menuCategories,
            'date'   => date('Y-m-d', strtotime($date))
        ];
    }

    /**
     * @param $item
     * @return bool
     */
    protected function isVoucherOrder(array $item): bool
    {
        return !isset($item['consumer_id']) && $item['type'] === Order::TYPE_VOUCHER_ORDER;
    }

    /**
     * @param $item
     * @return bool
     */
    protected function isPreOrder(array $item): bool
    {
        return isset($item['consumer_id']) && $item['type'] === Order::TYPE_PRE_ORDER;
    }

    /**
     * @param $item
     * @return bool
     */
    protected function isPosOrder(array $item): bool
    {
        return isset($item['consumer_id']) && $item['type'] === Order::TYPE_POS_ORDER;
    }
}
