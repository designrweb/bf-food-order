<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Services\ExportService;
use App\Services\UserService;
use App\Http\Requests\UserFormRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UserController
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /** @var UserService $service */
    protected $service;

    /**
     * UserController constructor.
     *
     * @param UserService $service
     */
    public function __construct(UserService $service)
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
        return view('users.index');
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
     * Returns a structure for the view page
     *
     * @param Request $request
     * @return array
     */
    public function getViewStructure(Request $request)
    {
        return $this->service->getViewStructure();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('users._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserFormRequest $request
     * @return array
     */
    public function store(UserFormRequest $request)
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

        return view('users.view', compact('resource'));
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

        return view('users._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserFormRequest $request
     * @param int             $id
     * @return array
     */
    public function update(UserFormRequest $request, $id)
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
