<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;

Route::middleware(['auth:sanctum', 'role:superadmin'])->group(function () {

});

Route::get('/', [AuthController::class, 'register'])->name('auth.register');
Route::post('/register', [AuthController::class, 'store'])->name('auth.store');
Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/login', [AuthController::class, 'logar'])->name('auth.logar');

Route::get('/produtos/{user}', [ProductController::class, 'index'])->name('product.index');

// Route::get('/consulta-cnpj/{cnpj}', [CompanyController::class, 'consultar'])->name('company.consultar');