<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::middleware('account_verification')->group(function () {
    Route::get('/', [EventController::class, 'latest'])->name('welcome');

    Route::resource('events', EventController::class)->only(['index', 'show']);

    Route::middleware('role:client')->group(function () {
        Route::resource('reservations', ReservationController::class)->only(['index', 'show', 'store']);
    });

    Route::middleware('role:organizer')->group(function () {
        Route::get('/organizer/dashboard', [OrganizerController::class, 'stats'])->name('organizer.dashboard');
        Route::resource('organizer.events', EventController::class)->except(['create', 'edit']);

    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [EventController::class, 'stats'])->name('admin.dashboard');
        Route::get('/dashboard/events', [EventController::class, 'adminIndex'])->name('admin.events');
        Route::resource('/dashboard/categories', CategoryController::class)->except(['create', 'edit', 'show']);
        Route::resource('/dashboard/organizers', OrganizerController::class)->only('index');
        Route::resource('/dashboard/clients', ClientController::class)->only('index');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
