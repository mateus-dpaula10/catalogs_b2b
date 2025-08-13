<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {

});

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'store'])->name('auth.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');