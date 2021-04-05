<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Services\ExportService;
use App\Services\LocationService;
use App\Services\UserService;
use App\Http\Requests\UserFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AdministratorController
 *
 * @package App\Http\Controllers
 */
class AdministratorController extends Controller
{
    /** @var UserService $service */
    protected $service;

    /**
     * @var LocationService
     */
    protected $locationService;

    /**
     * UserController constructor.
     *
     * @param UserService     $service
     * @param LocationService $locationService
     */
    public function __construct(UserService $service, LocationService $locationService)
    {
        $this->service         = $service;
        $this->locationService = $locationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('administrators.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new UserCollection($this->service->allAdministrators()))->toArray($request);
    }


    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new UserResource($this->service->getOne($id)))->toArray($request);
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getIndexStructure(Request $request)
    {
        return $this->service->getAdministratorIndexStructure();
    }

    /**
     * Returns a structure for the view page
     *
     * @param Request $request
     * @return array
     */
    public function getViewStructure(Request $request)
    {
        return $this->service->getAdministratorViewStructure();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $salutationsList = $this->service->getSalutationsList();
        $rolesList       = $this->service->getRolesList();
        $locationsList   = $this->locationService->getList();

        return view('administrators._form', [
            'salutationsList' => $salutationsList,
            'rolesList'       => $rolesList,
            'locationsList'   => $locationsList,
        ]);
    }

    /**
     * @param UserFormRequest $request
     * @return array
     */
    public function store(UserFormRequest $request)
    {
        return (new UserResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new UserResource($this->service->getOne($id)))->toArray(request());

        return view('administrators.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource                    = (new UserResource($this->service->getOne($id)))->toArray(request());
        $resource['salutationsList'] = $this->service->getSalutationsList();
        $resource['rolesList']       = $this->service->getRolesList();
        $resource['locationsList']   = $this->locationService->getList();

        return view('administrators._form', compact('resource'));
    }

    /**
     * @param UserFormRequest $request
     * @param                 $id
     * @return array
     */
    public function update(UserFormRequest $request, $id)
    {
        return (new UserResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('UserController@index')]);
    }

    /**
     * @param Request       $request
     * @param ExportService $exportService
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request, ExportService $exportService)
    {
        return $exportService->export($request, $this->service, UserCollection::class, User::class);
    }
}
