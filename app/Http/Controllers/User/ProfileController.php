<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Services\ConsumerService;
use App\Services\LocationGroupService;
use App\Services\LocationService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * @var LocationGroupService
     */
    protected $locationGroupService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var ConsumerService
     */
    protected $consumerService;

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * Create a new controller instance.
     *
     * @param LocationGroupService $locationGroupService
     * @param UserService          $userService
     * @param ConsumerService      $consumerService
     * @param LocationService      $locationService
     */
    public function __construct(LocationGroupService $locationGroupService,
                                UserService $userService,
                                ConsumerService $consumerService,
                                LocationService $locationService)
    {
        $this->locationGroupService = $locationGroupService;
        $this->userService          = $userService;
        $this->consumerService      = $consumerService;
        $this->locationService      = $locationService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locationGroupList = $this->locationGroupService->getList();
        $locationList      = $this->locationService->getList();

        return view('user.profile.index', [
            'locationGroupList' => $locationGroupList,
            'locationList'      => $locationList,
            'userInfo'          => auth()->user()->load('userInfo')
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        return view('user.profile._form', [
            'userInfo' => auth()->user()->load('userInfo')
        ]);
    }

    /**
     * @param UserFormRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserFormRequest $request)
    {
        $this->userService->update($request->all(), auth()->user()->id)->toArray();
    }
}
