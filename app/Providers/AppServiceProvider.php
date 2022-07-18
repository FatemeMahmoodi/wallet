<?php

namespace App\Providers;

use App\Interfaces\Repositories\PaymentRepositoryInterface;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Repositories\UserRepository;
use App\Services\PaymentGatewayRegistry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBinding();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function registerBinding()
    {

        $this->app->bind(UserRepositoryInterface::class, function () {
            return new UserRepository();
        });

        $this->app->bind(PaymentRepositoryInterface::class, function () {
            return new PaymentRepository();
        });

    }
}
