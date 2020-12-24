<?php

namespace App\Http\Controllers;

use App\Http\Resources\CombinedSettingCollection;
use App\Http\Resources\SettingCollection;
use App\Http\Resources\SettingResource;
use App\Services\SettingService;
use App\Http\Requests\SettingFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SettingController
 *
 * @package App\Http\Controllers
 */
class SettingController extends Controller
{
    /** @var SettingService $service */
    protected $service;

    public function __construct(SettingService $service)
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
        return view('settings.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function combinedIndex()
    {
        return view('settings.combined_index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new SettingCollection($this->service->all()))->toArray($request);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllCombined(Request $request)
    {
        return (new CombinedSettingCollection($this->service->allCombined()))->toArray($request);
    }


    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new SettingResource($this->service->getOne($id)))->toArray($request);
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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('settings._form');
    }

    /**
     * @param SettingFormRequest $request
     * @return array
     */
    public function store(SettingFormRequest $request)
    {
        return (new SettingResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function combinedUpdate(Request $request)
    {
        return $this->service->combinedUpdate($request->all());
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

        return view('settings.view', compact('resource'));
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

        return view('settings._form', compact('resource'));
    }

    /**
     * @param SettingFormRequest $request
     * @param                    $id
     * @return array
     */
    public function update(SettingFormRequest $request, $id)
    {
        return (new SettingResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('SettingController@index')]);
    }
}
