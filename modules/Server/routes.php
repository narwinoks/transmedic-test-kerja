<?php

use Illuminate\Support\Facades\Route;
use Modules\Server\Http\Controllers\v1\AuthController;
Route::prefix('server')->name('server.')->middleware('api')->group(function () {
    Route::name('auth')->prefix('auth')->controller(AuthController::class)->group(function () {
        Route::post('/login', 'login')->name('login');
        Route::post('/refresh', 'refresh')->name('refresh');
        Route::delete('/logout', 'logout')->name('logout')->middleware('auth:api');
    });
});
