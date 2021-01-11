<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use App\Http\Requests\OrderFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class OrderController
 *
 * @package App\Http\Controllers
 */
class OrderController extends Controller
{
    /** @var OrderService $service */
    protected $service;

    public function __construct(OrderService $service)
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
        return view('orders.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return OrderCollection
     */
    public function getAll(Request $request): OrderCollection
    {
        return new OrderCollection($this->service->all());
    }

    /**
     * Returns the resource.
     *
     * @param Request $request
     * @param         $id
     * @return OrderResource
     */
    public function getOne(Request $request, $id)
    {
        return new OrderResource($this->service->getOne($id));
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
        return view('orders._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param OrderFormRequest $request
     * @return OrderResource
     */
    public function store(OrderFormRequest $request): OrderResource
    {
        return new OrderResource($this->service->create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $resource = new OrderResource($this->service->getOne($id));

        return view('orders.view', compact('resource'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $resource = new OrderResource($this->service->getOne($id));

        return view('orders._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param OrderFormRequest $request
     * @param int              $id
     * @return OrderResource
     */
    public function update(OrderFormRequest $request, $id): OrderResource
    {
        return new OrderResource($this->service->update($request->all(), $id));
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

        return response()->json(['redirect_url' => action('OrderController@index')]);
    }
}
