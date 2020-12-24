<?php

namespace App\Http\Controllers;

use App\Consumer;
use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Services\ConsumerService;
use App\Http\Requests\ConsumerFormRequest;
use App\Services\ConsumerSubsidizationService;
use App\Services\LocationGroupService;
use App\Services\SubsidizationOrganizationService;
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

    /**
     * ConsumerController constructor.
     *
     * @param ConsumerService      $service
     * @param LocationGroupService $locationGroupService
     */
    public function __construct(ConsumerService $service, LocationGroupService $locationGroupService)
    {
        $this->service              = $service;
        $this->locationGroupService = $locationGroupService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Consumer::class);

        return view('consumers.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new ConsumerCollection($this->service->all()))->toArray($request);
    }


    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new ConsumerResource($this->service->getOne($id)))->toArray($request);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(SubsidizationOrganizationService $subsidizationOrganizationService)
    {
        $locationGroupList             = $this->locationGroupService->getList();
        $subsidizationOrganizationList = $subsidizationOrganizationService->getList();

        return view('consumers._form', [
            'locationGroupList'             => $locationGroupList,
            'subsidizationOrganizationList' => $subsidizationOrganizationList,
        ]);
    }

    /**
     * @param ConsumerFormRequest $request
     * @return array
     */
    public function store(ConsumerFormRequest $request)
    {
        return (new ConsumerResource($this->service->create($request)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new ConsumerResource($this->service->getOne($id)))->toArray(request());

        return view('consumers.view', compact('resource'));
    }

    /**
     * @param SubsidizationOrganizationService $subsidizationOrganizationService
     * @param                                  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(SubsidizationOrganizationService $subsidizationOrganizationService, $id)
    {
        /** @var array $resource */
        $resource                                  = (new ConsumerResource($this->service->getOne($id)))->toArray(request());
        $resource['locationGroupList']             = $this->locationGroupService->getList();
        $resource['subsidizationOrganizationList'] = $subsidizationOrganizationService->getList();

        return view('consumers._form', compact('resource'));
    }

    /**
     * @param ConsumerFormRequest $request
     * @param                     $id
     * @return array
     */
    public function update(ConsumerFormRequest $request, $id)
    {
        return (new ConsumerResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function generateCode($id)
    {
        return $this->service->generateCode($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadCode($id)
    {
        return (new Response($this->service->downloadCode($id), 200, ['mimeType' => 'image/jpg']));
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
