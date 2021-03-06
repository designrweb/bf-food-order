<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeliveryPlanningCollection;
use App\Http\Resources\DeliveryPlanningResource;
use App\Order;
use App\Services\DeliveryPlanningService;
use App\Http\Requests\DeliveryPlanningFormRequest;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class DeliveryPlanningController
 *
 * @package App\Http\Controllers
 */
class DeliveryPlanningController extends Controller
{
    /** @var DeliveryPlanningService $service */
    protected $service;

    public function __construct(DeliveryPlanningService $service)
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
        return view('delivery_planning.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new DeliveryPlanningCollection($this->service->all()))->toArray($request);
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
        return view('delivery_planning._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryPlanningFormRequest $request
     * @return array
     */
    public function store(DeliveryPlanningFormRequest $request)
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

        return view('delivery_planning.view', compact('resource'));
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

        return view('delivery_planning._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeliveryPlanningFormRequest $request
     * @param int     $id
     * @return array
     */
    public function update(DeliveryPlanningFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('DeliveryPlanningController@index')]);
    }

    /**
     * @param Request       $request
     * @param ExportService $exportService
     * @return mixed
     */
    public function export(Request $request, ExportService $exportService)
    {
        return $exportService->export($request, $this->service, DeliveryPlanningCollection::class, Order::class);
    }
}
