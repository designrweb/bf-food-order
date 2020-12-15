<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use App\Services\VacationService;
use App\Http\Requests\VacationFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class VacationController
 *
 * @package App\Http\Controllers
 */
class VacationController extends Controller
{
    /** @var VacationService $service */
    protected $service;

    public function __construct(VacationService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('vacation.index');
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
     * @param Request $request
     * @return array
     */
    public function getViewStructure(Request $request)
    {
        return $this->service->getViewStructure();
    }

    /**
     * @param LocationService $locationService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(LocationService $locationService)
    {
        $locationsList = $locationService->getList();

        return view('vacation._form', [
            'locationsList' => $locationsList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param VacationFormRequest $request
     * @return array
     */
    public function store(VacationFormRequest $request)
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

        return view('vacation.view', compact('resource'));
    }

    /**
     * @param LocationService      $locationService
     * @param                      $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LocationService $locationService, $id)
    {
        /** @var array $resource */
        $resource                  = $this->service->getOne($id)->toArray(request());
        $resource['locationsList'] = $locationService->getList();

        return view('vacation._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param VacationFormRequest $request
     * @param int                 $id
     * @return array
     */
    public function update(VacationFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('VacationController@index')]);
    }
}
