<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiKategoriController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('kategori', ApiKategoriController::class);