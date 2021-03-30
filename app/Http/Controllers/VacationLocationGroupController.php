<?php

namespace App\Http\Controllers;

use App\Http\Resources\VacationLocationGroupResource;
use App\Services\VacationLocationGroupService;
use App\Http\Requests\VacationLocationGroupFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class VacationLocationGroupController
 *
 * @package App\Http\Controllers
 */
class VacationLocationGroupController extends Controller
{
    /** @var VacationLocationGroupService $service */
    protected $service;

    public function __construct(VacationLocationGroupService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('vacation_location_group.index');
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
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('vacation_location_group._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VacationLocationGroupFormRequest $request
     * @return array
     */
    public function store(VacationLocationGroupFormRequest $request)
    {
        return $this->service->create($request->all())->toArray($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
       /** @var array $resource */
       $resource = $this->service->getOne($id)->toArray(request());

        return view('vacation_location_group.view', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());

        return view('vacation_location_group._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VacationLocationGroupFormRequest $request
     * @param int     $id
     * @return array
     */
    public function update(VacationLocationGroupFormRequest $request, $id)
    {
        return $this->service->update($request->all(), $id)->toArray($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('VacationLocationGroupController@index')]);
    }
}
