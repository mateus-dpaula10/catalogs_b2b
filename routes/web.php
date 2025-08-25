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
Route::get('/produtos/create/{user}', [ProductController::class, 'create'])->name('product.create');
Route::post('/produtos', [ProductController::class, 'store'])->name('product.store');
Route::get('/produtos/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
Route::patch('/produtos/update/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/produtos/destroy/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

// Route::get('/consulta-cnpj/{cnpj}', [CompanyController::class, 'consultar'])->name('company.consultar');