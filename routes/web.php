<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
USE App\Http\Controllers\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Bootstrap Auth)
|--------------------------------------------------------------------------
*/
Auth::routes();

/*
|--------------------------------------------------------------------------
| User Routes (Logged-in only)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // User Dashboard (default after login)
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Equipment booking
    Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/bookings/create/{id}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Only Admins)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::post('/dashboard', [AdminDashboardController::class, 'store'])->name('dashboard.store');
        Route::put('/dashboard/{id}', [AdminDashboardController::class, 'update'])->name('dashboard.update');
        Route::delete('/dashboard/{id}', [AdminDashboardController::class, 'destroy'])->name('dashboard.destroy');

        // Booking management
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::post('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
        Route::post('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
        Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');

        // 🔥 Soft delete + recycle bin
        Route::get('/bookings/trashed', [AdminBookingController::class, 'trashed'])->name('bookings.trashed');
        Route::post('/bookings/{id}/restore', [AdminBookingController::class, 'restore'])->name('bookings.restore');
        Route::delete('/bookings/{id}/force-delete', [AdminBookingController::class, 'forceDelete'])->name('bookings.forceDelete');

        // Return equipment
        Route::post('/bookings/{id}/return', [AdminBookingController::class, 'markReturned'])->name('bookings.return');
    });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
