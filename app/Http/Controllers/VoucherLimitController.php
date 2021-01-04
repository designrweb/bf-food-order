<?php

namespace App\Http\Controllers;

use App\Http\Resources\VoucherLimitCollection;
use App\Http\Resources\VoucherLimitResource;
use App\Services\MenuCategoryService;
use App\Services\VoucherLimitService;
use App\Http\Requests\VoucherLimitFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class VoucherLimitController
 *
 * @package App\Http\Controllers
 */
class VoucherLimitController extends Controller
{
    /** @var VoucherLimitService $service */
    protected $service;

    public function __construct(VoucherLimitService $service)
    {
        $this->service = $service;
    }

    /**
     * @param MenuCategoryService $menuCategoryService
     * @param VoucherLimitService $voucherLimitService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(MenuCategoryService $menuCategoryService, VoucherLimitService $voucherLimitService)
    {
        $menuCategories = $menuCategoryService->getList();
        $voucherLimits  = $voucherLimitService->getList();

        return view('voucher_limits.index', [
            'menuCategories' => $menuCategories,
            'voucherLimits'  => $voucherLimits,
        ]);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new VoucherLimitCollection($this->service->all()))->toArray($request);
    }


    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new VoucherLimitResource($this->service->getOne($id)))->toArray($request);
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
        return view('voucher_limits._form');
    }

    /**
     * @param VoucherLimitFormRequest $request
     * @return array
     */
    public function store(VoucherLimitFormRequest $request)
    {
        return (new VoucherLimitResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());

        return view('voucher_limits.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource = $this->service->getOne($id)->toArray(request());

        return view('voucher_limits._form', compact('resource'));
    }

    /**
     * @param VoucherLimitFormRequest $request
     * @param                         $id
     * @return array
     */
    public function update(VoucherLimitFormRequest $request, $id)
    {
        return (new VoucherLimitResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('VoucherLimitController@index')]);
    }
}
