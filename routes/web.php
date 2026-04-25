<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecialistController;
use App\Http\Controllers\SalonController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/salons', [SalonController::class, 'index'])->name('salons');
Route::get('/salons/{salon}', [HomeController::class, 'showSalon'])->name('salons.show');
Route::get('/services', [HomeController::class, 'services'])->name('services');

// Updated routes to use SpecialistController for better profile handling
Route::get('/specialists', [SpecialistController::class, 'index'])->name('specialists');
Route::get('/specialists/{id}', [SpecialistController::class, 'show'])->name('specialists.show');


Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isSalonOwner()) return redirect()->route('owner.dashboard');
    if ($user->isSpecialist()) return redirect()->route('specialist.dashboard');
    return redirect()->route('client.dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ClientController::class, 'profile'])->name('profile');
    Route::get('/appointments', [ClientController::class, 'appointments'])->name('appointments');
    Route::get('/book', [ClientController::class, 'bookForm'])->name('book');
    Route::post('/book', [ClientController::class, 'bookStore'])->name('book.store');
    Route::post('/review/{appointment}', [ClientController::class, 'storeReview'])->name('review.store');
});


Route::middleware(['auth', 'specialist'])->prefix('specialist')->name('specialist.')->group(function () {
    Route::get('/dashboard', [SpecialistController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [SpecialistController::class, 'profile'])->name('profile');
    Route::patch('/appointments/{appointment}/status', [SpecialistController::class, 'updateStatus'])->name('appointments.status');
});


Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [OwnerController::class, 'profile'])->name('profile');
    Route::get('/specialists', [OwnerController::class, 'specialists'])->name('specialists');
    Route::post('/specialists', [OwnerController::class, 'addSpecialist'])->name('specialists.store');
    Route::delete('/specialists/{specialist}', [OwnerController::class, 'removeSpecialist'])->name('specialists.destroy');
    Route::get('/services', [OwnerController::class, 'services'])->name('services');
    Route::get('/services/create', [OwnerController::class, 'createService'])->name('services.create');
    Route::post('/services', [OwnerController::class, 'storeService'])->name('services.store');
    Route::get('/services/{service}/edit', [OwnerController::class, 'editService'])->name('services.edit');
    Route::put('/services/{service}', [OwnerController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{service}', [OwnerController::class, 'destroyService'])->name('services.destroy');
    Route::get('/appointments', [OwnerController::class, 'appointments'])->name('appointments');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/appointments', [AdminController::class, 'appointments'])->name('appointments');
    Route::get('/salons', [AdminController::class, 'salons'])->name('salons');
    Route::get('/salons/create', [AdminController::class, 'createSalon'])->name('salons.create');
    Route::post('/salons', [AdminController::class, 'storeSalon'])->name('salons.store');
    Route::get('/salons/{salon}/edit', [AdminController::class, 'editSalon'])->name('salons.edit');
    Route::put('/salons/{salon}', [AdminController::class, 'updateSalon'])->name('salons.update');
    Route::delete('/salons/{salon}', [AdminController::class, 'destroySalon'])->name('salons.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
