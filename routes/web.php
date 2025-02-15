<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\MessagesController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/clients', [ClientsController::class, 'index'])->name('clients');
Route::post('/clients', [ClientsController::class, 'store']);
Route::delete('/clients/{id}', [ClientsController::class, 'destroy']);
Route::get('/clients/create', [ClientsController::class, 'create'])->name('clients.create');
Route::get('/clients/{id}/edit', [ClientsController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{id}', [ClientsController::class, 'update']);
Route::get('/messages', [MessagesController::class, 'index'])->name('messages');
Route::post('/messages', [MessagesController::class, 'store'])->name('messages.store');
Route::post('/send-messages', [MessagesController::class, 'sendMessages']);

Route::get('teste2', function () {
    return Inertia::render('Teste2');
});

Route::get('teste3', function () {
    return Inertia::render('Teste3');
});