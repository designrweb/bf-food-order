<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationGroupResource;
use App\Location;
use App\Services\LocationGroupService;
use App\Http\Requests\LocationGroupFormRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class LocationGroupController
 *
 * @package App\Http\Controllers
 */
class LocationGroupController extends Controller
{
    /** @var LocationGroupService $service */
    protected $service;

    /**
     * @var LocationService
     */
    protected $locationService;

    public function __construct(LocationGroupService $service, LocationService $locationService)
    {
        $this->service = $service;
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('location_group.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return $this->service->all()->toArray($request);
    }


    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return $this->service->getOne($id)->toArray($request);
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexStructure(Request $request)
    {
        return $this->service->getIndexStructure();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
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
     * @return array
     */
    public function store(LocationGroupFormRequest $request)
    {
        return $this->service->create($request->all())->toArray($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
       /** @var array $resource */
       $resource = $this->service->getOne($id)->toArray(request());

        return view('location_group.view', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());
        $resource['locationsList'] = $this->locationService->getList();

        return view('location_group._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LocationGroupFormRequest $request
     * @param int     $id
     * @return array
     */
    public function update(LocationGroupFormRequest $request, $id)
    {
        return $this->service->update($request->all(), $id)->toArray($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('LocationGroupController@index')]);
    }
}
