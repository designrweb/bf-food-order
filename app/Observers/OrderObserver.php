<?php

namespace App\Observers;

use App\Order;
use App\Payment;
use App\Services\PaymentService;
use App\SubsidizedMenuCategories;
use HttpException;

class OrderObserver
{
    /**
     * @var PaymentService
     */
    private $paymentService;

    /**
     * OrderObserver constructor.
     *
     * @param PaymentService $paymentService
     */
    public function __construct(PaymentService $paymentService){
        $this->paymentService = $paymentService;
    }
    /**
     * Handle the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        $r = $order;

        $rr = $this->paymentService->createPaymentBasedOnOrder($order);
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        //
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the order "restored" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the order "force deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
