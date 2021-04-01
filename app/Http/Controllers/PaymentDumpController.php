<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentDumpFileRequest;
use App\Http\Resources\PaymentDumpCollection;
use App\Http\Resources\PaymentDumpResource;
use App\Services\PaymentDumpService;
use Illuminate\Http\Request;

/**
 * Class PaymentDumpController
 *
 * @package App\Http\Controllers
 */
class PaymentDumpController extends Controller
{
    /**
     * @var PaymentDumpService
     */
    private $service;

    /**
     * PaymentDumpController constructor.
     *
     * @param PaymentDumpService $service
     */
    public function __construct(PaymentDumpService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('payment-dumps.index');
    }

    /**
     * Returns a listing of the resource
     *
     * @return PaymentDumpCollection
     */
    public function getAll(): PaymentDumpCollection
    {
        return new PaymentDumpCollection($this->service->all());
    }

    /**
     * Returns the resource
     *
     * @param  $id
     * @return PaymentDumpResource
     */
    public function getOne($id)
    {
        return new PaymentDumpResource($this->service->getOne($id));
    }

    /**
     * Creates a new PaymentDump model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @param PaymentDumpFileRequest $request
     * @return mixed
     */
    public function upload(PaymentDumpFileRequest $request)
    {
        $file   = $request->file('file');
        $upload = $this->service->uploadFile($file);

        if ($upload['status'] === 'success') {
            $data = [
                'file_name'  => $upload['fileName'],
                'company_id' => auth()->user()->company_id,
            ];

            $date     = explode('-', $upload['fileName'])[0];
            $dumpDate = date_create_from_format('Ymd', $date);
            if ($dumpDate) {
                $data['requested_at'] = date_format($dumpDate, 'Y-m-d');
            }

            $this->service->create($data);
        }

        return $upload;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process($id)
    {
        $payments = $this->service->parse($id);
        $this->service->fillPayments($payments);
        $this->service->markAsProcessed($id);

        return redirect()->route('payment-dumps.index');
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
}
