<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DropOffController;
use App\Http\Controllers\Admin\PickUpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::controller(DashboardController::class)->group(function() {
        Route::get('dashboard', 'index')->name('dashboard');
    });

    Route::controller(PickUpController::class)->group(function() {
        Route::get('pickup', 'index')->name('pickup.index');
    });
    Route::controller(DropOffController::class)->group(function() {
        Route::get('drop-off', 'index')->name('drop-off.index');
    });
    
});
