<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('shipments.index') : redirect()->route('login');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/shipments', App\Livewire\Shipments\Index::class)->name('shipments.index');

    Route::get('/trucks', App\Livewire\Trucks\Index::class)->name('trucks.index');
    
    Route::get('/drivers', App\Livewire\Drivers\Index::class)->name('drivers.index');
    
    Route::get('/reports', App\Livewire\Reports\Index::class)->name('reports.index');

});