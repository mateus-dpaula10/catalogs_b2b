<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {

});

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/login', [AuthController::class, 'store'])->name('auth.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/company', [CompanyController::class, 'index'])->name('company.index');
Route::get('/consulta-cnpj/{cnpj}', [CompanyController::class, 'consultar'])->name('company.consultar');