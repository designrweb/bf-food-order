<?php

namespace App\Http\Controllers;

use App\Consumer;
use App\Services\ConsumerService;
use App\Http\Requests\ConsumerFormRequest;
use App\Services\LocationGroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ConsumerController
 *
 * @package App\Http\Controllers
 */
class ConsumerController extends Controller
{
    /** @var ConsumerService $service */
    protected $service;

    /**
     * @var LocationGroupService
     */
    protected $locationGroupService;

    public function __construct(ConsumerService $service, LocationGroupService $locationGroupService)
    {
        $this->service = $service;
        $this->service = $service;
        $this->locationGroupService = $locationGroupService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Consumer::class);

        return view('consumers.index');
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
        $locationGroupList = $this->locationGroupService->getList();

        return view('consumers._form', [
            'locationGroupList' => $locationGroupList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ConsumerFormRequest $request
     * @return array
     */
    public function store(ConsumerFormRequest $request)
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

        return view('consumers.view', compact('resource'));
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
        $resource['locationGroupList'] = $this->locationGroupService->getList();

        return view('consumers._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ConsumerFormRequest $request
     * @param int                 $id
     * @return array
     */
    public function update(ConsumerFormRequest $request, $id)
    {
        return $this->service->update($request->all(), $id)->toArray($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('ConsumerController@index')]);
    }

    /**
     * @param $request
     * @param $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function updateImage(Request $request, $id)
    {
        $this->service->updateImage($request->all(), $id);

        return response()->json([
            'message' => 'Bild hochgeladen',
            'success' => true,
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage($id)
    {
        if ($this->service->removeImage($id)) {
            return response()->json([
                'message' => 'Bild entfernt',
                'success' => true,
            ], 200);
        }

        return response()->json([
            'message' => 'Something went wrong!',
            'success' => false,
        ], 500);
    }
}
