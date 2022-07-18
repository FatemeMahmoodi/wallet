<?php

namespace App\Http\Controllers\Api;

use App\Services\PaymentGatewayRegistry;
use Illuminate\Support\Facades\Request;

class PaymentController extends Controller
{

    protected $gatewayRegistry;

    function __construct(PaymentGatewayRegistry $registry)
    {
        $this->gatewayRegistry = $registry;
    }

    /**
     * @param Request $request
     * @param string $paymentGateway
     * @return mixed
     * @throws \Exception
     */
    public function callback(Request $request, string $paymentGateway): mixed
    {
        return $this->gatewayRegistry->get($paymentGateway)
            ->callback($request->all());
    }

}
