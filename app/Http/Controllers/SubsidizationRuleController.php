<?php

namespace App\Http\Controllers;

use App\Http\Resources\SubsidizationRuleResource;
use App\Services\SubsidizationRuleService;
use App\Http\Requests\SubsidizationRuleFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class SubsidizationRuleController
 *
 * @package App\Http\Controllers
 */
class SubsidizationRuleController extends Controller
{
    /** @var SubsidizationRuleService $service */
    protected $service;

    public function __construct(SubsidizationRuleService $service)
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
        return view('subsidization_rules.index');
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
        return view('subsidization_rules._form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SubsidizationRuleFormRequest $request
     * @return array
     */
    public function store(SubsidizationRuleFormRequest $request)
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

        return view('subsidization_rules.view', compact('resource'));
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

        return view('subsidization_rules._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SubsidizationRuleFormRequest $request
     * @param int     $id
     * @return array
     */
    public function update(SubsidizationRuleFormRequest $request, $id)
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

        return response()->json(['redirect_url' => action('SubsidizationRuleController@index')]);
    }
}
