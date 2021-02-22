<?php

namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Requests\api\mobile\LocationFormRequest;
use App\Http\Resources\Mobile\MobileLocationCollection;
use App\Http\Resources\Mobile\MobileLocationResource;
use App\Services\LocationService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

/**
 * Class LocationController
 *
 * @package App\Http\Controllers\api\mobile\v1
 */
class LocationController
{
    /**
     * @var LocationService
     */
    protected $service;

    /**
     * LocationController constructor.
     *
     * @param LocationService $service
     */
    public function __construct(LocationService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAll(Request $request)
    {
        return (new MobileLocationCollection($this->service->all()))->toArray($request);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new MobileLocationResource($this->service->getOne($id)))->toArray($request);
    }

    /**
     * @param LocationFormRequest $request
     * @return array
     */
    public function store(LocationFormRequest $request)
    {
        return (new MobileLocationResource($this->service->create($request->all())))->toArray($request);
    }
}