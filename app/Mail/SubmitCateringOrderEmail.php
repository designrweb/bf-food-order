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
     * @var
     */
    public $file;

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
        $this->generateAttachData();

        return $this->subject('Catering Order')
            ->attachData(stream_get_contents($this->file), 'catering_order.csv')
            ->from(env("MAIL_FROM_EMAIL"), env("MAIL_FROM_NAME"))
            ->view('mail.pos.catering_order.submit_order');
    }

    /**
     * Generate order data and save it in temp file
     */
    public function generateAttachData()
    {
        $data       = [];
        $delimiter  = ";";
        $this->file = fopen('php://temp', 'w');

        $data[] = ['Bestelldatum: ' . \Carbon\Carbon::parse($this->order->created_at)->translatedFormat('l, d.m.Y')];
        $data[] = ['Ort: ' . $this->order->user->location->name];
        $data[] = ['Lieferdatum: ' . \Carbon\Carbon::parse($this->order->delivery_date)->translatedFormat('l, d.m.Y')];
        $data[] = [];
        $data[] = ['Artikel', 'Menge'];

        if (!empty($this->order->orderItems)) {
            foreach ($this->order->orderItems->groupBy('cateringItem.cateringCategory.name') as $categoryName => $items) {
                $data[] = [$categoryName];
                foreach ($items as $item) {
                    $data[] = [$item->cateringItem->name, $item->quantity];
                }
            }
        }

        foreach ($data as $line) {
            fputcsv($this->file, $line, $delimiter);
        }

        fseek($this->file, 0);
    }
}
