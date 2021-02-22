<?php

namespace App\Http\Controllers\api\mobile\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\mobile\ConsumerFormRequest;
use App\Http\Resources\Mobile\MobileConsumerResource;
use App\Http\Resources\Mobile\MobileConsumerCollection;
use App\Services\ConsumerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ConsumerController
 *
 * @package App\Http\Controllers\api\mobile\v1
 */
class ConsumerController extends Controller
{

    /** @var ConsumerService $service */
    protected $service;

    /**
     * UserController constructor.
     *
     * @param ConsumerService $service
     */
    public function __construct(ConsumerService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return MobileConsumerCollection
     */
    public function getAll(Request $request)
    {
        return (new MobileConsumerCollection($this->service->allByUserId(auth('api')->user()->id)));
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new MobileConsumerResource($this->service->getOne($id)))->toArray($request);
    }

    /**
     * @param ConsumerFormRequest $request
     * @return array
     */
    public function store(ConsumerFormRequest $request)
    {
        return (new MobileConsumerResource($this->service->create($request)))->toArray($request);
    }

    /**
     * @param ConsumerFormRequest $request
     * @param                     $id
     * @return array
     */
    public function update(ConsumerFormRequest $request, $id)
    {
        return (new MobileConsumerResource($this->service->update($request, $id)))->toArray($request);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function generateCode($id)
    {
        return $this->service->generateCode($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadCode($id)
    {
        return (new Response($this->service->downloadCode($id), 200, ['mimeType' => 'image/jpg']));
    }

    /**
     * Remove the specified resource from storage.
     *
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
