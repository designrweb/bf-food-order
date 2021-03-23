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
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PaymentController
 *
 * @package App\Http\Controllers\User
 */
class PaymentController extends Controller
{
    /** @var BankTransactionService */
    private $bankTransactionService;

    /** @var MealOrderService */
    private $mealOrderService;

    /**
     * PaymentController constructor.
     *
     * @param BankTransactionService $bankTransactionService
     * @param MealOrderService       $mealOrderService
     */
    public function __construct(BankTransactionService $bankTransactionService, MealOrderService $mealOrderService)
    {
        $this->bankTransactionService = $bankTransactionService;
        $this->mealOrderService       = $mealOrderService;
    }

    /**
     * @param Request     $request
     * @param UserService $userService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function bankTransactions(Request $request, UserService $userService)
    {
        return view('user.payments.bank-transactions', [
            'userConsumerExists' => $userService->isConsumersExists($request->user())
        ]);
    }

    /**
     * Returns a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function getBankTransactionsIndexStructure(Request $request): array
    {
        return $this->bankTransactionService->getIndexStructureForUser();
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
     * @param Request     $request
     * @param UserService $userService
     * @return \Illuminate\View\View
     */
    public function mealOrders(Request $request, UserService $userService)
    {
        return view('user.payments.meal-orders', [
            'userConsumerExists' => $userService->isConsumersExists($request->user())
        ]);
    }

    /**
     * Returns payments for meal orders
     *
     * @return array
     */
    public function getMealOrdersStructure(): array
    {
        return $this->mealOrderService->getIndexStructureForUser();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllMealOrders(Request $request): array
    {
        return (new PaymentCollection($this->mealOrderService->all()))->toArray($request);
    }
}
