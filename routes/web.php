<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\Admin\UserController; // Ditambahkan untuk UserController
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

Route::middleware('auth')->group(function () {
    Route::get('/shipments', App\Livewire\Shipments\Index::class)->name('shipments.index');
    Route::get('/trucks', App\Livewire\Trucks\Index::class)->name('trucks.index');
    Route::get('/drivers', App\Livewire\Drivers\Index::class)->name('drivers.index');
    Route::get('/reports', App\Livewire\Reports\Index::class)->name('reports.index');
    Route::get('/profile', App\Livewire\Profile\Index::class)->name('profile.index');

    // --- Route Baru untuk Manajemen Akun Admin menggunakan Livewire ---
    Route::prefix('admin')
         ->name('admin.')
         // ->middleware('is_admin') // Opsional: Middleware khusus admin
         ->group(function () {
        
        Route::get('/users', AdminUsersIndex::class)->name('users.index'); // Mengarah ke Komponen Livewire
        
        // Route DELETE yang sebelumnya ke Admin\UserController tidak diperlukan lagi jika semua aksi via Livewire
    });

});