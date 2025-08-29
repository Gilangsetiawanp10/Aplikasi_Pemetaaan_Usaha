<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/maps', [MapController::class, 'index'])->name('maps.index');
