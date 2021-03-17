<?php

namespace App\Http\ViewComposers;

use App\Services\ConsumerService;
use Illuminate\View\View;

class ConsumerCompose
{
    /**
     * @var ConsumerService
     */
    private $service;

    public function __construct(ConsumerService $consumerService)
    {
        $this->service = $consumerService;
    }

    public function compose(View $view)
    {
        $view->with('consumer', $this->service->getCurrentConsumer());
    }
}
