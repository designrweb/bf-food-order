<?php

namespace App\Events;

use App\CateringOrder;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CateringOrderSubmit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var CateringOrder
     */
    public $order;

    /**
     * Create a new event instance.
     *
     * @param CateringOrder $order
     */
    public function __construct(CateringOrder $order)
    {
        $this->order = $order;
    }
}
