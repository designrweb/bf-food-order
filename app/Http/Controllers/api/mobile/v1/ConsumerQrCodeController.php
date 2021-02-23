<?php

namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\mobile\ConsumerQrCodeFormRequest;
use App\Http\Resources\Mobile\MobileConsumerQrCodeCollection;
use App\Http\Resources\Mobile\MobileConsumerQrCodeResource;
use App\Services\ConsumerQrCodeService;
use Illuminate\Http\Request;

/**
 * Class ConsumerQrCodeController
 *
 * @package App\Http\Controllers\api\mobile\v1
 */
class ConsumerQrCodeController extends Controller
{
    /**
     * @var ConsumerQrCodeService
     */
    protected $service;

    /**
     * ConsumerQrCodeController constructor.
     *
     * @param ConsumerQrCodeService $service
     */
    public function __construct(ConsumerQrCodeService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return MobileConsumerQrCodeCollection
     */
    public function getAll(Request $request)
    {
        return (new MobileConsumerQrCodeCollection($this->service->all()));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new MobileConsumerQrCodeResource($this->service->getOne($id)))->toArray($request);
    }

    /**
     * @param ConsumerQrCodeFormRequest $request
     * @return array
     */
    public function store(ConsumerQrCodeFormRequest $request)
    {
        return (new MobileConsumerQrCodeResource($this->service->create($request->all())))->toArray($request);
    }

    /**
     * @param ConsumerQrCodeFormRequest $request
     * @param                           $id
     * @return array
     */
    public function update(ConsumerQrCodeFormRequest $request, $id)
    {
        return (new MobileConsumerQrCodeResource($this->service->update($request->all(), $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->service->remove($id);
        } catch (\Throwable $t) {
            return response()->json(['error' => $t->getMessage()]);
        }

        return response()->json();
    }
}