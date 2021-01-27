<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationGroupCollection;
use App\Services\LocationGroupService;
use App\Http\Requests\LocationGroupFormRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;

/**
 * Class LocationGroupController
 *
 * @package App\Http\Controllers
 */
class LocationGroupController extends Controller
{
    /** @var LocationGroupService $service */
    protected $service;

    /** @var LocationService */
    protected $locationService;

    /**
     * LocationGroupController constructor.
     *
     * @param LocationGroupService $service
     * @param LocationService      $locationService
     */
    public function __construct(LocationGroupService $service, LocationService $locationService)
    {
        $this->service         = $service;
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('location_group.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return LocationGroupCollection
     */
    public function getAll(Request $request): LocationGroupCollection
    {
        return new LocationGroupCollection($this->service->all());
    }

    /**
     * Returns a resource
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOne($id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->getOne($id));
    }

    /**
     * Returns a structure for the index page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexStructure(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->getIndexStructure());
    }


    /**
     * Returns a structure for the view page
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getViewStructure(): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->getViewStructure());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $locationsList = $this->locationService->getList();

        return view('location_group._form', [
            'locationsList' => $locationsList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocationGroupFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationGroupFormRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $resource = $this->service->getOne($id);

        return view('location_group.view', compact('resource'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $resource                  = $this->service->getOne($id);
        $resource['locationsList'] = $this->locationService->getList();

        return view('location_group._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LocationGroupFormRequest $request
     * @param                          $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LocationGroupFormRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->service->update($request->all(), $id));
    }

    /**
     * @param $locationId
     * @return mixed
     */
    public function getList($locationId = null)
    {
        return $this->service->getList($locationId);
    }
}
