<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubsidizedMenuCategoriesResource;
use App\Services\SubsidizedMenuCategoriesService;
use App\Http\Requests\SubsidizedMenuCategoriesFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SubsidizedMenuCategoriesController
 *
 * @package App\Http\Controllers
 */
class SubsidizedMenuCategoriesController extends Controller
{
    /** @var SubsidizedMenuCategoriesService $service */
    protected $service;

    public function __construct(SubsidizedMenuCategoriesService $service)
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
        return view('subsidized_menu_categories.index');
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
        return view('subsidized_menu_categories._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubsidizedMenuCategoriesFormRequest $request
     * @return array
     */
    public function store(SubsidizedMenuCategoriesFormRequest $request)
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

        return view('subsidized_menu_categories.view', compact('resource'));
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

        return view('subsidized_menu_categories._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubsidizedMenuCategoriesFormRequest $request
     * @param int     $id
     * @return array
     */
    public function update(SubsidizedMenuCategoriesFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('SubsidizedMenuCategoriesController@index')]);
    }
}
