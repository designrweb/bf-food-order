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
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new PaymentCollection($this->service->all()))->toArray($request);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new PaymentResource($this->service->getOne($id)))->toArray($request);
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
     * @param PaymentFormRequest $request
     * @return array
     */
    public function store(PaymentFormRequest $request)
    {
        return (new PaymentResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new PaymentResource($this->service->getOne($id)))->toArray(request());

        return view('payments.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource                  = (new PaymentResource($this->service->getOne($id)))->toArray(request());
        $resource['consumersList'] = $this->consumerService->getList();

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
        return $this->service->update($request->all(), $id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
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
