<?php

namespace App\Http\Controllers;

use App\Http\Resources\MenuItemCollection;
use App\Http\Resources\MenuItemResource;
use App\Services\MenuItemService;
use App\Services\MenuCategoryService;
use App\Http\Requests\MenuItemFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MenuItemController
 *
 * @package App\Http\Controllers
 */
class MenuItemController extends Controller
{
    /** @var MenuItemService $service */
    protected $service;

    public function __construct(MenuItemService $service)
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
        return view('menu_items.index');
    }

    /**
     * @param Request $request
     * @return MenuItemCollection
     */
    public function getAll(Request $request)
    {
        return new MenuItemCollection($this->service->all());
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
        return (new MenuItemResource($this->service->getOne($id)))->toArray($request);
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
     * @param MenuCategoryService $menuCategoryService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(MenuCategoryService $menuCategoryService)
    {
        $menuCategoriesList = $menuCategoryService->getList();

        return view('menu_items._form', [
            'menuCategoriesList' => $menuCategoriesList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuItemFormRequest $request
     * @return array
     */
    public function store(MenuItemFormRequest $request)
    {
        return (new MenuItemResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new MenuItemResource($this->service->getOne($id)))->toArray(request());

        return view('menu_items.view', compact('resource'));
    }

    /**
     * @param MenuCategoryService $menuCategoryService
     * @param                     $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(MenuCategoryService $menuCategoryService, $id)
    {
        /** @var array $resource */
        $resource                       = (new MenuItemResource($this->service->getOne($id)))->toArray(request());
        $resource['menuCategoriesList'] = $menuCategoryService->getList();

        return view('menu_items._form', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function replicate($id)
    {
        /** @var array $resource */
        $replicatedId = $this->service->replicate($id);

        return redirect()->route('menu-items.edit', $replicatedId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuItemFormRequest $request
     * @param int                 $id
     * @return array
     */
    public function update(MenuItemFormRequest $request, $id)
    {
        return (new MenuItemResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('MenuItemController@index')]);
    }
}
