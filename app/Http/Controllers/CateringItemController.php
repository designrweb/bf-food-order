<?php

namespace App\Http\Controllers;

use App\Http\Resources\CateringItemResource;
use App\Services\CateringCategoryService;
use App\Services\CateringItemService;
use App\Http\Requests\CateringItemFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class CateringItemController
 *
 * @package App\Http\Controllers
 */
class CateringItemController extends Controller
{
    /** @var CateringItemService $service */
    protected $service;

    public function __construct(CateringItemService $service)
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
        return view('catering_items.index');
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
     * @param CateringCategoryService $cateringCategoryService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CateringCategoryService $cateringCategoryService)
    {
        $cateringCategoriesList = $cateringCategoryService->getList();
        $statusesList           = $this->service->getStatusList();

        return view('catering_items._form', [
            'cateringCategoriesList' => $cateringCategoriesList,
            'statusesList'           => $statusesList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CateringItemFormRequest $request
     * @return array
     */
    public function store(CateringItemFormRequest $request)
    {
        return $this->service->create($request->all())->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());

        return view('catering_items.view', compact('resource'));
    }

    /**
     * @param CateringCategoryService $cateringCategoryService
     * @param                         $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CateringCategoryService $cateringCategoryService, $id)
    {
        /** @var array $resource */
        $resource                           = $this->service->getOne($id)->toArray(request());
        $resource['cateringCategoriesList'] = $cateringCategoryService->getList();
        $resource['statusesList']           = $this->service->getStatusList();

        return view('catering_items._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CateringItemFormRequest $request
     * @param int                     $id
     * @return array
     */
    public function update(CateringItemFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('CateringItemController@index')]);
    }
}
