<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;

Route::get('/', [MapController::class, 'index'])->name('maps.index');
Route::get('/potensi', [MapController::class, 'potensi'])->name('maps.potensi');

// Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
