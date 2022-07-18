<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Api\V1\Payment\DepositRequest;
use App\Http\Requests\Api\V1\Payment\WithdrawRequest;
use App\Services\PaymentGatewayRegistry;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{
    protected $gatewayRegistry;

    function __construct(PaymentGatewayRegistry $registry)
    {
        $this->gatewayRegistry = $registry;
    }

    public function Deposit(DepositRequest $request)
    {
        return $this->gatewayRegistry->get($request->input('gateway'))
            ->pay(Auth::user(), $order);
    }

    public function Withdraw(WithdrawRequest $request)
    {

    }


}
