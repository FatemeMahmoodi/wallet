<?php

namespace App\Services;

use App\Interfaces\Services\PaymentGatewayInterface;

class PaymentGatewayRegistry
{

    protected $gateways = [];

    /**
     * @param $name
     * @param PaymentGatewayInterface $instance
     * @return $this
     */
    function register($name, PaymentGatewayInterface $instance)
    {
        $this->gateways[$name] = $instance;
        return $this;
    }

    function get($name)
    {
        if (in_array($name, $this->gateways)) {
            return $this->gateways[$name];
        } else {
            throw new \Exception("Invalid gateway");
        }
    }

}
