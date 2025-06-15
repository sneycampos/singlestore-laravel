<?php

use Illuminate\Support\Facades\Route;

Route::get('/users', [App\Http\UserController::class, 'index']);
Route::post('/users', [App\Http\UserController::class, 'store']);
Route::get('/users/{user}', [App\Http\UserController::class, 'show']);
Route::put('/users/{user}', [App\Http\UserController::class, 'update']);
Route::delete('/users/{user}', [App\Http\UserController::class, 'destroy']);
