<?php

namespace App\Services\Reports\Financial;

use App\Payment;

/**
 * Class FinancialReportComponent
 *
 * @package App\Services\Reports\Financial
 */
abstract class FinancialReportComponent
{
    protected $startDate;
    protected $endDate;
    protected $location;

    protected $incomingTransactions;
    protected $manuallyBookedMoney;
    protected $orderedMeals;
    protected $spontaneousOrders;
    protected $voucherOrders;

    /**
     * @param $startDate
     * @param $endDate
     * @param $location
     */
    public function initReport($startDate, $endDate, $location)
    {
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->location  = $location;

        // 1) all incoming money (positive transactions)
        $this->incomingTransactions = $this->getAllIncomingTransactions();

        // 5) Manually booked money (manual transactions)
        $this->manuallyBookedMoney = $this->getManuallyBookedMoney();

        // 2)all ordered meals that have not been canceled in time
        $this->orderedMeals = $this->getAllOrderedMeals();

        // 3) Spontaneous orders
        $this->spontaneousOrders = $this->getAllSpontaneousOrders();

        // 4) Vouchers
        $this->voucherOrders = $this->getAllVoucherOrders();
    }

    /**
     * @return array
     */
    protected function getAllIncomingTransactions(): array
    {
        return $this->getPaymentsData([Payment::TYPE_BANK_TRANSACTION]);
    }

    /**
     * @return array
     */
    protected function getManuallyBookedMoney(): array
    {
        return $this->getPaymentsData([Payment::TYPE_MANUAL_TRANSACTION]);
    }

    /**
     * @return array
     */
    protected function getAllOrderedMeals(): array
    {
        return $this->getPaymentsData([Payment::TYPE_PRE_ORDER_CANCELLATION, Payment::TYPE_PRE_ORDER,
            Payment::TYPE_POS_ORDER_SUBSIDIZED, Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION,
            Payment::TYPE_PRE_ORDER_SUBSIDIZED_REFUND, Payment::TYPE_PRE_ORDER_SUBSIDIZED_CANCELLATION_REFUND]);
        // TODO: remove if not needed
        //        return $this->getOrdersData(Order::TYPE_PRE_ORDER);
    }

    /**
     * @return array
     */
    protected function getAllSpontaneousOrders(): array
    {
        return $this->getPaymentsData([Payment::TYPE_POS_ORDER, Payment::TYPE_POS_ORDER_SUBSIDIZED,
            Payment::TYPE_POS_ORDER_SUBSIDIZED_REFUND]);
        // TODO: remove if not needed
        //        return $this->getOrdersData(Order::TYPE_POS_ORDER);
    }

    /**
     * @return array
     */
    protected function getAllVoucherOrders(): array
    {
        return $this->getPaymentsData([Payment::TYPE_VOUCHER]);
        // TODO: remove if not needed
        //        return $this->getOrdersData(Order::TYPE_VOUCHER_ORDER);
    }

    /**
     * Prepare data based on payment's type
     *
     * @param $type
     * @return array
     */
    protected function getPaymentsData($type): array
    {
        $result = [
            'items' => [],
            'total' => 0,
        ];

        // todo move to repository
        $payments = Payment::whereIn('type', $type)
            ->where('created_at', '>', $this->startDate)
            ->where('created_at', '<', $this->endDate)
            ->with(['consumer.user.location' => function ($query) {
                $query->where('locations.id', $this->location->location_id);
            }])
            ->get();

        foreach ($payments as $payment) {
            $result['total']   += $payment->amount;
            $result['items'][] = [
                'customer_id'   => $payment->consumer->account_id,
                'customer_name' => $payment->consumer->fullName,
                'delivery_date' => $payment->transacted_at != null
                    ? date('d.m.Y', strtotime($payment->transacted_at))
                    : date('d.m.Y', strtotime($payment->created_at)),
                'posted_date'   => date('d.m.Y', strtotime($payment->created_at)),
                'amount'        => $payment->amount,
            ];
        }

        return $result;
    }
}
