<?php

use App\Http\Controllers\Api\LigaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KlubController;
use App\Http\Controllers\Api\PemainController;
use App\Http\Controllers\Api\FanController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::get('liga', [LigaController::class, 'index']);
// Route::post('liga', [LigaController::class, 'store']);
// Route::get('liga/{id}', [LigaController::class, 'show']);
// Route::put('liga/{id}', [LigaController::class, 'update']);
// Route::delete('liga/{id}', [LigaController::class, 'destroy']);

Route::resource('liga', LigaController::class)->except(['edit', 'create']);
Route::resource('klub', KlubController::class)->except(['edit', 'create']);
Route::resource('pemain', PemainController::class)->except(['edit', 'create']);

Route::resource('fan', FanController::class)->except(['edit', 'create']);
