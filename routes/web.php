<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('teste1', function () {
    return Inertia::render('Teste1');
});

Route::get('teste2', function () {
    return Inertia::render('Teste2');
});

Route::get('teste3', function () {
    return Inertia::render('Teste3');
});