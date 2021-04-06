<?php

namespace App\Listeners;

use App\Events\CateringOrderSubmit;
use Illuminate\Support\Facades\Mail;

class SendCateringOrderConfirmationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param CateringOrderSubmit $event
     * @return void
     */
    public function handle(CateringOrderSubmit $event)
    {
        $order = $event->order;

        if (!empty($order->user->location->company->settings()->where('setting_name', 'email')
            ->first())) {
            Mail::to($order->user->location->company->settings()->where('setting_name', 'email')->first()->value)->send(new \App\Mail\SubmitCateringOrderEmail($order));
        }
    }
}
