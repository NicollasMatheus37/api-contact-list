<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello World!']);
});

// Auth routes
Route::group([], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

// User routes
Route::apiResource('/users', UserController::class)->only('show', 'destroy')->middleware('auth:sanctum');

// Contact routes
Route::apiResource('/contacts', ContactController::class)->middleware('auth:sanctum');

// Search for CEP
Route::get('/cep', [CepController::class, 'searchForCep']);

// Fallback route
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});
