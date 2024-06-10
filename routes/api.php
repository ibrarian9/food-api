<?php

use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post("/login", [UsersController::class, "login"]);
Route::post("/register", [UsersController::class, "register"]);

Route::apiResource('/foods', App\Http\Controllers\Api\FoodController::class);
Route::get('/orders', [App\Http\Controllers\Api\FoodController::class, 'showHistory']);
Route::post('/order', [App\Http\Controllers\Api\FoodController::class, 'addHistory']);
