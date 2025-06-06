<?php

use App\Http\Controllers\PasswordResetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\Users\Index as AdminUsersIndex;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('shipments.index') : redirect()->route('login');
});

// Auth
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

// Tracking
Route::get('/track/{truck}', [TrackingController::class, 'startTracking'])->name('tracking.start-tracking');
Route::get('/track/{truck}/started-success', [TrackingController::class, 'startedSuccess'])->name('tracking.started-success');
Route::get('/track/{truck}/on-going', [TrackingController::class, 'onGoing'])->name('tracking.on-going');
Route::get('/track/{truck}/on-going/success', [TrackingController::class, 'finishSuccess'])->name('tracking.finish-success');
Route::get('/track/{truck}/report', [TrackingController::class, 'createReport'])->name('tracking.create-report');
Route::post('/track/{truck}/report', [TrackingController::class, 'storeReport'])->name('tracking.store-report');
Route::get('/track/{truck}/report/success', [TrackingController::class, 'reportSuccess'])->name('tracking.report-success');

// Inspection
Route::get('/inspection/{truck}', [InspectionController::class, 'create'])->name('inspections.create');
Route::post('/inspection/{truck}', [InspectionController::class, 'store'])->name('inspections.store');

Route::middleware('auth')->group(function () {
    Route::get('/shipments', App\Livewire\Shipments\Index::class)->name('shipments.index');

    Route::get('/shipments/schedules', App\Livewire\Schedules\Index::class)->name('schedules.index');

    Route::get('/trucks', App\Livewire\Trucks\Index::class)->name('trucks.index');
    Route::get('/drivers', App\Livewire\Drivers\Index::class)->name('drivers.index');
    Route::get('/reports', App\Livewire\Reports\Index::class)->name('reports.index');
    Route::get('/profile', App\Livewire\Profile\Index::class)->name('profile.index');

    Route::get('/inspections', App\Livewire\Inspections\Index::class)->name('inspections.index');
    Route::get('/inspections/schedule', App\Livewire\Inspections\Schedule::class)->name('inspections.schedule');

    // --- Route Baru untuk Manajemen Akun Admin menggunakan Livewire ---
    Route::prefix('admin')
         ->name('admin.')
         // ->middleware('is_admin') // Opsional: Middleware khusus admin
         ->group(function () {
        
        Route::get('/users', AdminUsersIndex::class)->name('users.index'); // Mengarah ke Komponen Livewire
        
        // Route DELETE yang sebelumnya ke Admin\UserController tidak diperlukan lagi jika semua aksi via Livewire
    });

});