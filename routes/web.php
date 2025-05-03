<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TrackingController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('shipments.index') : redirect()->route('login');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassworForm'])->name('password.request');
Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::post('/reset-password', [PasswordResetController::class, 'resetUserPassword'])->name('password.update');

Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');

// Tracking
Route::get('/track/{truck}', [TrackingController::class, 'startTracking'])->name('tracking.start-tracking');
Route::get('/track/{truck}/started-success', [TrackingController::class, 'startedSuccess'])->name('tracking.started-success');
Route::get('/track/{truck}/on-going', [TrackingController::class, 'onGoing'])->name('tracking.on-going');
Route::get('/track/{truck}/on-going/success', [TrackingController::class, 'finishSuccess'])->name('tracking.finish-success');
Route::get('/track/{truck}/report', [TrackingController::class, 'createReport'])->name('tracking.create-report');
Route::post('/track/{truck}/report', [TrackingController::class, 'storeReport'])->name('tracking.store-report');
Route::get('/track/{truck}/report/success', [TrackingController::class, 'reportSuccess'])->name('tracking.report-success');

Route::middleware('auth')->group(function () {
    Route::get('/shipments', App\Livewire\Shipments\Index::class)->name('shipments.index');

    Route::get('/trucks', App\Livewire\Trucks\Index::class)->name('trucks.index');

    Route::get('/drivers', App\Livewire\Drivers\Index::class)->name('drivers.index');
    
    Route::get('/reports', App\Livewire\Reports\Index::class)->name('reports.index');
});