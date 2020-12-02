<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserFormRequest;
use App\Services\ConsumerService;
use App\Services\LocationGroupService;
use App\Services\UserService;
use Illuminate\Http\Request;

class HomeController extends Controller
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
     * Create a new controller instance.
     *
     * @param LocationGroupService $locationGroupService
     * @param UserService          $userService
     * @param ConsumerService      $consumerService
     */
    public function __construct(LocationGroupService $locationGroupService, UserService $userService, ConsumerService $consumerService)
    {
        $this->locationGroupService = $locationGroupService;
        $this->userService          = $userService;
        $this->consumerService      = $consumerService;
        $this->middleware('auth');
    }

    /**W
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $locationGroupList = $this->locationGroupService->getList();

        return view('home', [
            'locationGroupList' => $locationGroupList
        ]);
    }

    /**
     * @param UserFormRequest $request
     */
    public function update(UserFormRequest $request)
    {
        $this->userService->update($request->all(), auth()->user()->id)->toArray($request);

        $data            = $request->all()['consumer'];
        $data['user_id'] = auth()->user()->id;
        $this->consumerService->create($data);

        return redirect()->route('profile.index');
    }
}
