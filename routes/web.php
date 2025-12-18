<?php

use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
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
    Route::controller(CarController::class)->group(function() {
        Route::get('car-detail', 'index')->name('car-detail.index');
        Route::get('car-detail/create', 'create')->name('car-detail.create');
        Route::get('car-detail/{id}/edit', 'edit')->name('car-detail.edit');
    });
    Route::controller(DriverController::class)->group(function() {
        Route::get('driver-detail', 'index')->name('driver-detail.index');
        Route::get('driver-detail/create', 'create')->name('driver-detail.create');
        Route::get('driver-detail/{id}/edit', 'edit')->name('driver-detail.edit');
    });
});
