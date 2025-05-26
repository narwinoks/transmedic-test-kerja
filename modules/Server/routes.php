<?php

use Illuminate\Support\Facades\Route;

Route::prefix('Server')->name('Server.')->middleware('api')->group(function () {
    Route::get('/', function () {
        return 'This is the Server module.';
    });
});
