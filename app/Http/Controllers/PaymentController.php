<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Services\ConsumerService;
use App\Services\PaymentService;
use App\Http\Requests\PaymentFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PaymentController
 *
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /** @var PaymentService $service */
    protected $service;
    /**
     * @var ConsumerService
     */
    private $consumerService;

    public function __construct(PaymentService $service, ConsumerService $consumerService)
    {
        $this->service         = $service;
        $this->consumerService = $consumerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('payments.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return PaymentCollection
     */
    public function getAll(Request $request): PaymentCollection
    {
        return new PaymentCollection($this->service->all());
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @param         $id
     * @return PaymentResource
     */
    public function getOne(Request $request, $id): PaymentResource
    {
        return new PaymentResource($this->service->getOne($id));
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

    public function getMealOrdersStructure(Request $request)
    {
        return $this->service->getMealOrdersStructure();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $consumersList = $this->consumerService->getList();

        return view('payments._form', compact('consumersList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PaymentFormRequest $request
     * @return PaymentResource
     */
    public function store(PaymentFormRequest $request)
    {
        return new PaymentResource($this->service->create($request->all()));
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

        return view('payments.view', compact('resource'));
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

        return view('payments._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentFormRequest $request
     * @param int                $id
     * @return array
     */
    public function update(PaymentFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('PaymentController@index')]);
    }

    /**
     * Lists all payments by Meal Orders.
     *
     * @return \Illuminate\View\View
     */
    public function mealOrders()
    {
        return view('payments.meal-orders');
    }
}
