<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Services\ConsumerService;
use App\Services\LocationGroupService;
use App\Services\LocationService;
use App\Services\MenuCategoryService;
use App\Services\UserService;
use Illuminate\Http\Request;

class MenuCategoryController extends Controller
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
        return view('user.food_order.index', [
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param Request             $request
     * @param MenuCategoryService $categoryService
     * @return \App\Http\Resources\MenuCategoryCollection
     */
    public function getAll(Request $request, MenuCategoryService $categoryService)
    {
       return $categoryService->all();
    }
}
