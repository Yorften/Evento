<?php

use App\Http\Controllers\BanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationController;
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
        Route::get('/reservations/pending', [ReservationController::class, 'pending'])->name('reservations.pending');
        Route::get('/reservations/history', [ReservationController::class, 'history'])->name('reservations.history');
        Route::resource('reservations', ReservationController::class)->only(['index', 'store']);
        Route::get('reservations/{group}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::resource('/notifications', NotificationController::class)->only('show');
    });

    Route::middleware('role:organizer')->group(function () {
        Route::get('/organizer/dashboard', [OrganizerController::class, 'stats'])->name('organizer.dashboard');
        Route::get('/organizer/dashboard/events', [EventController::class, 'accepted'])->name('organizer.events');
        Route::get('/organizer/dashboard/events/pending', [EventController::class, 'pending'])->name('events.pending');
        Route::get('/organizer/dashboard/events/history', [EventController::class, 'history'])->name('events.history');
        Route::get('/organizer/dashboard/events/rejected', [EventController::class, 'rejected'])->name('events.rejected');
        Route::get('/organizer/dashboard/events/clients/{event}', [EventController::class, 'clients'])->name('events.clients');
        Route::patch('/organizer/dashboard/events/{event}', [EventController::class, 'update']);
        Route::resource('/organizer/dashboard/events', EventController::class)->only(['store', 'destroy']);
        Route::get('/organizer/dashboard/events/verify/{group}', [ReservationController::class, 'verify'])->name('reservations.verify');
        Route::get('/organizer/dashboard/events/reject/{group}', [ReservationController::class, 'reject'])->name('reservations.reject');
        Route::get('/organizer/notifications/{event}', [NotificationController::class, 'event'])->name('notifications.event');

    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [EventController::class, 'stats'])->name('admin.dashboard');
        Route::get('/dashboard/events', [EventController::class, 'adminIndex'])->name('admin.events');
        Route::patch('/dashboard/events/verify/{event}', [EventController::class, 'verify'])->name('events.verify');
        Route::patch('/dashboard/events/reject/{event}', [EventController::class, 'reject'])->name('events.reject');
        Route::get('/events/preview/{event}', [EventController::class, 'preview'])->name('events.preview');
        Route::resource('/dashboard/categories', CategoryController::class)->except(['create', 'edit', 'show']);
        Route::resource('/dashboard/organizers', OrganizerController::class)->only('index');
        Route::resource('/dashboard/clients', ClientController::class)->only('index');
        Route::post('/dashboard/bans/{user}', [BanController::class, 'store'])->name('bans.store');
        Route::delete('/dashboard/bans/{user}', [BanController::class, 'destroy'])->name('bans.destroy');
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/profile/organizers', OrganizerController::class)->only('update');
    Route::resource('/profile/clients', ClientController::class)->only('update');
});

require __DIR__ . '/auth.php';
