<?php

use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PaymentController;
use Illuminate\Support\Facades\Route;

Route::post('/signIn', [UserController::class, 'signIn']);
Route::post('/signUp', [UserController::class, 'signUp']);

Route::middleware(['auth:api'])
    ->group(function () {
        Route::post('/signOut', [UserController::class, 'signOut']);
        Route::get('/currentUser', [UserController::class, 'currentUser']);

        Route::prefix('payments')
            ->group(function () {
                Route::post('/deposit', [PaymentController::class, 'deposit']);
                Route::post('/withdraw', [PaymentController::class, 'withdraw']);
                Route::get('/', [PaymentController::class, 'index']);
            });
    });
