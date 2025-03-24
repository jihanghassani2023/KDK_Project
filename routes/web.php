<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\AdminController;

Route::get('/', [QueueController::class, 'index'])->name('home');
Route::post('/queue/create', [QueueController::class, 'create'])->name('queue.create');
Route::get('/display', [QueueController::class, 'display'])->name('queue.display');

// Operator Routes
Route::prefix('operator')->group(function () {
    Route::get('/', [OperatorController::class, 'index'])->name('operator.index');
    Route::get('/dashboard/{counter}', [OperatorController::class, 'dashboard'])->name('operator.dashboard');
    Route::post('/call-next', [OperatorController::class, 'callNext'])->name('operator.callNext');
    Route::post('/complete', [OperatorController::class, 'complete'])->name('operator.complete');
    Route::post('/skip', [OperatorController::class, 'skip'])->name('operator.skip');
});

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Services
    Route::get('/services', [AdminController::class, 'services'])->name('admin.services');
    Route::post('/services', [AdminController::class, 'createService'])->name('admin.services.create');

    // Counters
    Route::get('/counters', [AdminController::class, 'counters'])->name('admin.counters');
    Route::post('/counters', [AdminController::class, 'createCounter'])->name('admin.counters.create');
});