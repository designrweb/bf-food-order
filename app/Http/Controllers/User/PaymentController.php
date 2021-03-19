<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentCollection;
use App\Http\Resources\PaymentResource;
use App\Payment;
use App\Services\ConsumerService;
use App\Services\Payments\BankTransactionService;
use App\Services\Payments\MealOrderService;
use App\Services\PaymentService;
use App\Http\Requests\PaymentFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PaymentController
 *
 * @package App\Http\Controllers
 */
class PaymentController extends Controller
{
    /** @var PaymentService $service */
    protected $service;

    /** @var ConsumerService */
    private $consumerService;

    /** @var BankTransactionService */
    private $bankTransactionService;

    /** @var MealOrderService */
    private $mealOrderService;

    /**
     * PaymentController constructor.
     *
     * @param PaymentService         $service
     * @param ConsumerService        $consumerService
     * @param BankTransactionService $bankTransactionService
     * @param MealOrderService       $mealOrderService
     */
    public function __construct(
        PaymentService $service,
        ConsumerService $consumerService,
        BankTransactionService $bankTransactionService,
        MealOrderService $mealOrderService
    )
    {
        $this->service                = $service;
        $this->consumerService        = $consumerService;
        $this->bankTransactionService = $bankTransactionService;
        $this->mealOrderService       = $mealOrderService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bankTransactions()
    {
        return view('user.payments.bank-transactions');
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getBankTransactionsIndexStructure(Request $request): array
    {
        return $this->bankTransactionService->getIndexStructure();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllBankTransactions(Request $request): array
    {
        return (new PaymentCollection($this->bankTransactionService->all()))->toArray($request);
    }

    /**
     * Lists all payments by Meal Orders.
     *
     * @return \Illuminate\View\View
     */
    public function mealOrders()
    {
        return view('user.payments.meal-orders');
    }

    /**
     * Returns payments for meal orders
     *
     * @return array
     */
    public function getMealOrdersStructure(): array
    {
        return $this->mealOrderService->getIndexStructure();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllMealOrders(Request $request): array
    {
        return (new PaymentCollection($this->mealOrderService->all()))->toArray($request);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return array
     */
    public function getOne(Request $request, $id)
    {
        return (new PaymentResource($this->service->getOne($id)))->toArray($request);
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
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create()
    {
        $consumersList = $this->consumerService->getList();

        return view('user.payments._form', compact('consumersList'));
    }

    /**
     * @param PaymentFormRequest $request
     * @return array
     */
    public function store(PaymentFormRequest $request)
    {
        $data         = $request->all();
        $data['type'] = Payment::TYPE_MANUAL_TRANSACTION;

        // todo use mutators for amount_locale
        $data['amount'] = str_replace(',', '.', $data['amount_locale']);

        return (new PaymentResource($this->service->create($data)))->toArray($request);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        /** @var array $resource */
        $resource = (new PaymentResource($this->service->getOne($id)))->toArray(request());

        return view('user.payments.view', compact('resource'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        /** @var array $resource */
        $resource                  = (new PaymentResource($this->service->getOne($id)))->toArray(request());
        $resource['consumersList'] = $this->consumerService->getList();

        return view('user.payments._form', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentFormRequest $request
     * @param int                $id
     * @return array
     */
    public function update(PaymentFormRequest $request, $id)
    {
        return $this->service->update($request->all(), $id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->service->remove($id);

        return response()->json(['redirect_url' => action('PaymentController@index')]);
    }
}
