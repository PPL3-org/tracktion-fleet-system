<?php

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/location/start-tracking', [LocationController::class, 'startTracking']);
Route::post('/location/finish-tracking', [LocationController::class, 'finishTracking']);