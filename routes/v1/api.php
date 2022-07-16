<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/signIn', [UserController::class, 'signIn']);
Route::post('/signUp', [UserController::class, 'signUp']);


Route::middleware(['auth:api'])
    ->group(function () {
        Route::post('/signOut', [UserController::class, 'signOut']);
        Route::get('/currentUser', [UserController::class, 'currentUser']);
    });
