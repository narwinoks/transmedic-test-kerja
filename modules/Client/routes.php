<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Controllers\ClientController;
Route::prefix('/')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('login');

    Route::get('{any}', [ClientController::class, 'show'])
        ->where('any', '.*')
        ->name('dynamic');
});
