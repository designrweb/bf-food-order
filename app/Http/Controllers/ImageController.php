<?php

namespace App\Http\Controllers;

use App\Consumer;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController
{

    /** @var ImageService $service */
    protected $service;

    /**
     * ImageController constructor.
     *
     * @param ImageService $service
     */
    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request)
    {
        return $this->service->storeImage($request->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeImage(Request $request)
    {
        return $this->service->removeImage($request);
    }
}