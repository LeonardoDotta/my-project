<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard'); 
});