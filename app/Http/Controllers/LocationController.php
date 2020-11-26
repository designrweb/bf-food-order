<?php

namespace App\Http\Controllers;

use App\Company;
use App\Services\CompanyService;
use App\Services\LocationService;
use App\Http\Requests\LocationFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LocationController
 *
 * @package App\Http\Controllers
 */
class LocationController extends Controller
{
    /** @var LocationService $service */
    protected $service;

    /**
     * @var CompanyService
     */
    protected $companyService;

    /**
     * LocationController constructor.
     *
     * @param LocationService $service
     * @param CompanyService  $companyService
     */
    public function __construct(LocationService $service, CompanyService $companyService)
    {
        $this->service = $service;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('locations.index');
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
     * Returns a listing of the resource.W
     *
     * @param Request $request
     * @return array
     */
    public function getIndexStructure(Request $request)
    {
        return $this->service->getIndexStructure();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $companiesList = $this->companyService->getList();

        return view('locations._form', [
            'companiesList' => $companiesList
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LocationFormRequest $request
     * @return array
     */
    public function store(LocationFormRequest $request)
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

        return view('locations.view', compact('resource'));
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
        $resource['companiesList'] = $this->companyService->getList();

        return view('locations._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LocationFormRequest $request
     * @param int                 $id
     * @return array
     */
    public function update(LocationFormRequest $request, $id)
    {
        return $this->service->update($request->all(), $id)->toArray($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('LocationController@index')]);
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
