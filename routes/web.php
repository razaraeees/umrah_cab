<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdditionalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DriverController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\DropOffController;
use App\Http\Controllers\Admin\PickUpController;
use App\Http\Controllers\Admin\RouteFaresController;
use App\Http\Controllers\Admin\HotelController;





Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index')->name('dashboard');
    });

    Route::get('profile', function () {
        return view('admin.profile');
    })->name('profile');

    Route::controller(PickUpController::class)->group(function () {
        Route::get('pickup', 'index')->name('pickup.index');
    });
    Route::controller(DropOffController::class)->group(function () {
        Route::get('drop-off', 'index')->name('drop-off.index');
    });
    Route::controller(CarController::class)->group(function () {
        Route::get('car-detail', 'index')->name('car-detail.index');
        Route::get('car-detail/create', 'create')->name('car-detail.create');
        Route::get('car-detail/{id}/edit', 'edit')->name('car-detail.edit');
    });
    Route::controller(DriverController::class)->group(function () {
        Route::get('driver-detail', 'index')->name('driver-detail.index');
        Route::get('driver-detail/create', 'create')->name('driver-detail.create');
        Route::get('driver-detail/{id}/edit', 'edit')->name('driver-detail.edit');
    });
    Route::controller(RouteFaresController::class)->group(function () {
        Route::get('routefares', 'index')->name('routefares.index');
        Route::get('routefares/create', 'create')->name('routefares.create');
        Route::get('routefares/{id}/edit', 'edit')->name('routefares.edit');
    });
    Route::controller(BookingController::class)->group(function () {
        Route::get('booking-list', 'index')->name('booking-list.index');
        Route::get('booking/create', 'create')->name('booking-list.create');
        Route::get('booking/{id}/edit', 'edit')->name('booking-list.edit');
    });
    Route::controller(CityController::class)->group(function () {
        Route::get('cities', 'index')->name('cities.index');
    });
    Route::controller(HotelController::class)->group(function () {
        Route::get('hotels', 'index')->name('hotel.index');
    });
    Route::get('additional-charges', function () {
        return view('admin.additional_charges.index');
    })->name('additional-charges.index');
    Route::controller(BookingController::class)->group(function () {
        Route::get('booking', 'index')->name('booking.index');
        Route::get('booking/create', 'create')->name('booking.create');
        Route::get('booking/{id}/edit', 'edit')->name('booking.edit');
    });
    Route::controller(AdditionalController::class)->group(function () {
        Route::get('additional', 'index')->name('additional.index');
    });
    Route::get('/get-clipboard-text', function () {
        $text = cache()->get('clipboard_' . auth()->id(), '');
        return response()->json([
            'text' => $text
        ]);
    })->name('get-clipboard-text');

    
    Route::controller(AccountController::class)->group(function () {
        Route::get('driver-account', 'index')->name('driver-account.index');
        Route::get('driver-account/{id}/details', 'driverDetails')->name('driver-account.details');
    });
});



require __DIR__ . '/auth.php';
