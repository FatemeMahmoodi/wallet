<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PaymentMethodStatus;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\Payment\DepositRequest;
use App\Http\Requests\Api\V1\Payment\WithdrawRequest;
use App\Http\Resources\OperationSuccessResource;
use App\Interfaces\Repositories\PaymentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Services\PaymentGatewayRegistry;
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

    public function deposit(DepositRequest $request)
    {
        return $this->gatewayRegistry->get($request->input('gateway'))
            ->pay(Auth::user(), $order);
    }

    public function withdraw(WithdrawRequest $request)
    {
         DB::transaction(function () use ($request) {
            $this->paymentRepository->create([
                'payment_method' => PaymentMethodStatus::WITHDRAWAL,
                'amount' => $request->input('amount'),
                'user_id' => Auth::id()
            ]);
            $this->userRepository->update(
                Auth::id(),
                ['balance' => $request->input('amount')]
            );
        });

        return new OperationSuccessResource([
            'operation' => trans('payment::withdraw'),
            'status' => true
        ]);
    }

    public function paymentsReports()
    {


    }


}
