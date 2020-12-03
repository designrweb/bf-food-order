<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubsidizationOrganizationResource;
use App\Services\CompanyService;
use App\Services\SubsidizationOrganizationService;
use App\Http\Requests\SubsidizationOrganizationFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SubsidizationOrganizationController
 *
 * @package App\Http\Controllers
 */
class SubsidizationOrganizationController extends Controller
{
    /** @var SubsidizationOrganizationService $service */
    protected $service;

    /**
     * @var CompanyService
     */
    protected $companyService;

    public function __construct(SubsidizationOrganizationService $service, CompanyService $companyService)
    {
        $this->service        = $service;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('subsidization_organizations.index');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $companiesList = $this->companyService->getList();

        return view('subsidization_organizations._form', [
            'companiesList' => $companiesList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubsidizationOrganizationFormRequest $request
     * @return array
     */
    public function store(SubsidizationOrganizationFormRequest $request)
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

        return view('subsidization_organizations.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource                  = $this->service->getOne($id)->toArray(request());
        $resource['companiesList'] = $this->companyService->getList();

        return view('subsidization_organizations._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubsidizationOrganizationFormRequest $request
     * @param int                                  $id
     * @return array
     */
    public function update(SubsidizationOrganizationFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('SubsidizationOrganizationController@index')]);
    }
}
