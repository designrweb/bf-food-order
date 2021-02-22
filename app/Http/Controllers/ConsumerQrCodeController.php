<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsumerQrCodeCollection;
use App\Http\Resources\ConsumerQrCodeResource;
use App\Services\ConsumerQrCodeService;
use App\Http\Requests\ConsumerQrCodeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ConsumerQrCodeController
 *
 * @package App\Http\Controllers
 */
class ConsumerQrCodeController extends Controller
{
    /** @var ConsumerQrCodeService $service */
    protected $service;

    public function __construct(ConsumerQrCodeService $service)
    {
        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('consumer_qr_codes.index');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new ConsumerQrCodeCollection($this->service->all()))->toArray($request);
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
        return (new ConsumerQrCodeResource($this->service->getOne($id)))->toArray($request);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('consumer_qr_codes._form');
    }

    /**
     * @param ConsumerQrCodeFormRequest $request
     * @return array
     */
    public function store(ConsumerQrCodeFormRequest $request)
    {
        return (new ConsumerQrCodeResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new ConsumerQrCodeResource($this->service->getOne($id)))->toArray(request());

        return view('consumer_qr_codes.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource = (new ConsumerQrCodeResource($this->service->getOne($id)))->toArray(request());

        return view('consumer_qr_codes._form', compact('resource'));
    }

    /**
     * @param ConsumerQrCodeFormRequest $request
     * @param                           $id
     * @return array
     */
    public function update(ConsumerQrCodeFormRequest $request, $id)
    {
        return (new ConsumerQrCodeResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('ConsumerQrCodeController@index')]);
    }
}
