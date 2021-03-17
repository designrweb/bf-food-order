<?php

namespace App\Http\ViewComposers;

use App\Services\ConsumerService;
use App\User;
use Illuminate\View\View;

class ConsumerListCompose
{
    /** @var ConsumerService */
    private $consumerService;

    public function __construct(ConsumerService $consumerService)
    {
        $this->consumerService = $consumerService;
    }

    public function compose(View $view)
    {
        if (!auth()->check() || auth()->user()->role !== User::ROLE_USER) return;


    }
}