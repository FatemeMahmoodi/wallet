<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PaymentMethodStatus;
use App\Enums\PaymentStatusEnum;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\Payment\DepositRequest;
use App\Http\Requests\Api\V1\Payment\WithdrawRequest;
use App\Http\Resources\OperationSuccessResource;
use App\Http\Resources\Payment\PaymentResources;
use App\Interfaces\Repositories\PaymentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Services\PaymentGatewayRegistry;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{

    function __construct(
        protected PaymentGatewayRegistry     $gatewayRegistry,
        protected UserRepositoryInterface    $userRepository,
        protected PaymentRepositoryInterface $paymentRepository
    )
    {
    }

    /**
     * @param DepositRequest $request
     * @return OperationSuccessResource
     */

    public function deposit(DepositRequest $request)
    {
        //todo connect to paymentGateway
        //return $this->gatewayRegistry->get($request->input('gateway'))
        //->pay(array_merge(['user'=>Auth::user()], $request->all()));

        $result = DB::transaction(function () use ($request) {
            $this->paymentRepository->create([
                'payment_method' => PaymentMethodStatus::DEPOSIT,
                'amount' => $request->input('amount'),
                'status' => PaymentStatusEnum::SUCCESS,
                'user_id' => Auth::id()
            ]);
            $currentBalance = Auth::user()->balance;
          return  $this->userRepository->update(
                Auth::id(),
                ['balance' => $currentBalance + $request->input('amount')]
            );
        });

        return new OperationSuccessResource([
            'operation' => trans('payment.deposit'),
            'status' => $result
        ]);
    }

    /**
     * @param WithdrawRequest $request
     * @return OperationSuccessResource
     */
    public function withdraw(WithdrawRequest $request): OperationSuccessResource
    {
        $result = DB::transaction(function () use ($request) {
            $this->paymentRepository->create([
                'payment_method' => PaymentMethodStatus::WITHDRAWAL,
                'amount' => $request->input('amount'),
                'status' => PaymentStatusEnum::SUCCESS,
                'user_id' => Auth::id()
            ]);
            $currentBalance = Auth::user()->balance;
          return  $this->userRepository->update(
                Auth::id(),
                ['balance' => $currentBalance - $request->input('amount')]
            );
        });

        return new OperationSuccessResource([
            'operation' => trans('payment.withdraw'),
            'status' => $result
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return PaymentResources::collection($this->paymentRepository->list($request->all()));

    }


}
