<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;

Route::get('/', [MapController::class, 'index'])->name('maps.index');

// Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
