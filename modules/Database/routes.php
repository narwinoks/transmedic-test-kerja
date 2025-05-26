<?php

use Illuminate\Support\Facades\Route;

Route::prefix('Database')->name('Database.')->middleware('api')->group(function () {
    Route::get('/', function () {
        return 'This is the Database module.';
    });
});
