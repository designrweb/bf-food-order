<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuCategoryCollection;
use App\Http\Resources\MenuCategoryResource;
use App\MenuCategory;
use App\Services\LocationService;
use App\Services\MenuCategoryService;
use App\Http\Requests\MenuCategoryFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MenuCategoryController
 *
 * @package App\Http\Controllers
 */
class MenuCategoryController extends Controller
{
    /** @var MenuCategoryService $service */
    protected $service;

    public function __construct(MenuCategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|Response|\Illuminate\View\View
     */
    public function index()
    {
        return view('menu_categories.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new MenuCategoryCollection($this->service->all()))->toArray($request);
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
        $locationsList  = $locationService->getList();
        $existingOrders = $this->service->all()->pluck('category_order', 'category_order')->toArray();

        return view('menu_categories._form', [
            'locationsList'  => $locationsList,
            'existingOrders' => $existingOrders,
            'taxRates'       => $this->service->getTaxRates()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuCategoryFormRequest $request
     * @return array
     */
    public function store(MenuCategoryFormRequest $request)
    {
        $data = $request->all();

        $data['presaleprice'] = $data['presaleprice_locale'];
        $data['price']        = $data['price_locale'];

        return $this->service->create($data)->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());

        return view('menu_categories.view', compact('resource'));
    }

    /**
     * @param LocationService $locationService
     * @param                 $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(LocationService $locationService, $id)
    {
        /** @var array $resource */
        $resource                   = $this->service->getOne($id)->toArray(request());
        $resource['locationsList']  = $locationService->getList();
        $resource['existingOrders'] = $this->service->getByLocationId($resource['location_id'])->pluck('category_order', 'category_order')->toArray();
        $resource['taxRates']       = $this->service->getTaxRates();

        return view('menu_categories._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuCategoryFormRequest $request
     * @param int                     $id
     * @return array
     */
    public function update(MenuCategoryFormRequest $request, $id)
    {
        $data = $request->all();

        $data['presaleprice'] = $data['presaleprice_locale'];
        $data['price']        = $data['price_locale'];

        return $this->service->update($data, $id)->toArray($request);
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

        return response()->json(['redirect_url' => action('MenuCategoryController@index')]);
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->service->getList();
    }
}
