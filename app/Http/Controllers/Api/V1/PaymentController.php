<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\Controller;
use App\Services\PaymentGatewayRegistry;

class PaymentController extends Controller
{
    protected $gatewayRegistry;

    function __construct(PaymentGatewayRegistry $registry)
    {
        $this->gatewayRegistry = $registry;
    }

    public function Deposit()
    {
        return $this->gatewayRegistry->get($request->get('gateway'))
            ->pay(Auth::user(), $order);
    }

}
