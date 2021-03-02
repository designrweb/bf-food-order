<?php

namespace App\Http\Controllers\User;

use App\Consumer;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsumerCollection;
use App\Http\Resources\ConsumerResource;
use App\Services\ConsumerService;
use App\Http\Requests\ConsumerFormRequest;
use App\Services\ExportService;
use App\Services\LocationGroupService;
use App\Services\LocationService;
use App\Services\SettingService;
use App\Services\SubsidizationOrganizationService;
use App\Setting;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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
     * @param Request $request
     * @return array|Application|Factory|View
     */
    public function index(Request $request)
    {
        return view('user.consumer.index');
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
     * @param LocationService $locationService
     * @return Application|Factory|View
     */
    public function create(LocationService $locationService)
    {
        $locationList      = $locationService->getList();

        return view('user.consumer._form', [
            'locationList'      => $locationList
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
     * @param SettingService $settingService
     * @param                $id
     * @return Application|Factory|View
     */
    public function show(SettingService $settingService, $id)
    {
        $resource                  = (new ConsumerResource($this->service->getOne($id)))->toArray(request());
        $subsidizationSupportEmail = $settingService->getSubsidizationSupportEmail();

        return view('user.consumer.view', compact('resource', 'subsidizationSupportEmail'));
    }

    /**
     * @param                                  $id
     * @return Application|Factory|View
     */
    public function edit($id, LocationService $locationService)
    {
        $resource          = (new ConsumerResource($this->service->getOne($id)))->toArray(request());
        $locationList      = $locationService->getList();

        return view('user.consumer._form', compact('resource', 'locationList'));
    }

    /**
     * @param ConsumerFormRequest $request
     * @param                     $id
     * @return array
     */
    public function update(ConsumerFormRequest $request, $id)
    {
        return (new ConsumerResource($this->service->update($request, $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return mixed
     * @throws Exception
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
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('User\ConsumerController@index')]);
    }

    /**
     * @param $request
     * @param $id
     * @return bool|JsonResponse
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
     * @return JsonResponse
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

    /**
     * @param ExportService $exportService
     * @param Request       $request
     * @return BinaryFileResponse
     */
    public function export(Request $request, ExportService $exportService)
    {
        return $exportService->export($request, $this->service, ConsumerCollection::class, Consumer::class);
    }

    /**
     * @param                 $locationId
     * @param LocationService $locationService
     * @return array
     */
    public function getLocationList($locationId, LocationService $locationService): array
    {
        return $locationService->getOne($locationId)->locationGroups->toArray();
    }

    /**
     * @param                 $locationId
     * @param LocationService $locationService
     * @return array
     */
    public function qrCode($locationId, LocationService $locationService): array
    {
        return view('qr');
    }
}
