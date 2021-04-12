<?php

namespace App\Http\ViewComposers;

use App\Services\UserService;
use Illuminate\View\View;

class ProfileCompose
{

    /**
     * @var UserService
     */
    private $service;

    /**
     * ProfileCompose constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('isCompletedProfile', $this->service->isCompletedProfile());
    }
}