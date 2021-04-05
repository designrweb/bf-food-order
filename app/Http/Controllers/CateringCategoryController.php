<?php

namespace App\Http\Controllers;

use App\Http\Resources\CateringCategoryCollection;
use App\Http\Resources\CateringCategoryResource;
use App\Services\CateringCategoryService;
use App\Http\Requests\CateringCategoryFormRequest;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CateringCategoryController
 *
 * @package App\Http\Controllers
 */
class CateringCategoryController extends Controller
{
    /** @var CateringCategoryService $service */
    protected $service;

    public function __construct(CateringCategoryService $service)
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
        return view('catering_categories.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new CateringCategoryCollection($this->service->all()))->toArray($request);
    }


    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new CateringCategoryResource($this->service->getOne($id)))->toArray($request);
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

        return view('catering_categories._form', [
            'locationsList' => $locationsList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CateringCategoryFormRequest $request
     * @return array
     */
    public function store(CateringCategoryFormRequest $request)
    {
        return (new CateringCategoryResource($this->service->create($request->all())))->toArray
        ($request);
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
        $resource = (new CateringCategoryResource($this->service->getOne($id)))->toArray(request());

        return view('catering_categories.view', compact('resource'));
    }

    /**
     * @param LocationService $locationService
     * @param                 $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LocationService $locationService, $id)
    {
        /** @var array $resource */
        $resource                  = (new CateringCategoryResource($this->service->getOne($id)))
            ->toArray(request());
        $resource['locationsList'] = $locationService->getList();

        return view('catering_categories._form', compact('resource'));
    }

    /**
     * @param CateringCategoryFormRequest $request
     * @param                             $id
     * @return array
     */
    public function update(CateringCategoryFormRequest $request, $id)
    {
        return (new CateringCategoryResource($this->service->update($request->all(), $id)))
            ->toArray($request);
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

        return response()->json(['redirect_url' => action('CateringCategoryController@index')]);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->service->getList();
    }
}
