<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/', [EventController::class, 'latest'])->name('events.latest');
});




Route::middleware('auth', 'account_verification')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('events', EventController::class)->except(['create', 'edit']);
    Route::resource('organizers', OrganizerController::class)->except(['create', 'store', 'edit']);
    Route::resource('clients', ClientController::class)->except(['create', 'store', 'edit']);
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
