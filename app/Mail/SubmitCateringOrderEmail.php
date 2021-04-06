<?php

namespace App\Mail;

use App\CateringOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubmitCateringOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var CateringOrder
     */
    public $order;

    /**
     * Create a new message instance.
     *
     * @param CateringOrder $order
     */
    public function __construct(CateringOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Catering Order')
            ->from(env("MAIL_FROM_EMAIL"), env("MAIL_FROM_NAME"))
            ->view('mail.pos.catering_order.submit_order');
    }
}
