<?php

namespace App\Providers;

use App\Services\PaymentGatewayRegistry;
use App\Services\SampleGatewayService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{

    function register()
    {
        $this->app->singleton(PaymentGatewayRegistry::class);
    }

    function boot()
    {
        $this->app->make(PaymentGatewayRegistry::class)
            ->register("sample", new SampleGatewayService());
    }

}
