<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubsidizationRuleCollection;
use App\Http\Resources\SubsidizationRuleResource;
use App\Services\MenuCategoryService;
use App\Services\SubsidizationOrganizationService;
use App\Services\SubsidizationRuleService;
use App\Http\Requests\SubsidizationRuleFormRequest;
use App\Services\SubsidizedMenuCategoriesService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SubsidizationRuleController
 *
 * @package App\Http\Controllers
 */
class SubsidizationRuleController extends Controller
{
    /** @var SubsidizationRuleService $service */
    protected $service;

    /**
     * SubsidizationRuleController constructor.
     *
     * @param SubsidizationRuleService $service
     */
    public function __construct(SubsidizationRuleService $service)
    {
        $this->service = $service;
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('subsidization_rules.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new SubsidizationRuleCollection($this->service->all()))->toArray($request);
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
        return (new SubsidizationRuleResource($this->service->getOne($id)))->toArray($request);
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
     * @param SubsidizationOrganizationService $subsidizationOrganizationService
     * @param SubsidizedMenuCategoriesService  $subsidizedMenuCategoriesService
     * @return Application|Factory|View
     */
    public function create(SubsidizationOrganizationService $subsidizationOrganizationService, SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService)
    {
        $subsidizationOrganizations  = $subsidizationOrganizationService->getList();
        $subsidizationMenuCategories = $subsidizedMenuCategoriesService->getSubsidizationMenuCategories();

        return view('subsidization_rules._form', [
            'subsidizationOrganizations'  => $subsidizationOrganizations,
            'subsidizationMenuCategories' => $subsidizationMenuCategories,
        ]);
    }

    /**
     * @param SubsidizationRuleFormRequest $request
     * @return array
     */
    public function store(SubsidizationRuleFormRequest $request)
    {
        return (new SubsidizationRuleResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new SubsidizationRuleResource($this->service->getOne($id)))->toArray(request());

        return view('subsidization_rules.view', compact('resource'));
    }

    /**
     * @param SubsidizationOrganizationService $subsidizationOrganizationService
     * @param SubsidizedMenuCategoriesService  $subsidizedMenuCategoriesService
     * @param                                  $id
     * @return Application|Factory|View
     */
    public function edit(SubsidizationOrganizationService $subsidizationOrganizationService, SubsidizedMenuCategoriesService $subsidizedMenuCategoriesService, $id)
    {
        /** @var array $resource */
        $resource                                = (new SubsidizationRuleResource($this->service->getOne($id)))->toArray(request());
        $resource['subsidizationOrganizations']  = $subsidizationOrganizationService->getList();
        $resource['subsidizationMenuCategories'] = $subsidizedMenuCategoriesService->getSubsidizationMenuCategories($id);

        return view('subsidization_rules._form', compact('resource'));
    }

    /**
     * @param SubsidizationRuleFormRequest $request
     * @param                              $id
     * @return array
     */
    public function update(SubsidizationRuleFormRequest $request, $id)
    {
        return (new SubsidizationRuleResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('SubsidizationRuleController@index')]);
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
