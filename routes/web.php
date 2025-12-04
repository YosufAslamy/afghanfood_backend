<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/login', [LoginController::class, 'login']);
Route::get('/api/menu', [MenuController::class, 'menu']);
Route::post('/api/categories', [MenuController::class, 'addCategory']);
Route::post('/api/fooods', [MenuController::class, 'addfood']);
Route::put('/api/categories/{id}', [MenuController::class, 'updateCategory']);
Route::put('/api/foods/{id}', [MenuController::class, 'updateFood']);
Route::delete('/api/categories/{id}', [MenuController::class, 'deleteCategory']);
Route::delete('/api/foods/{id}', [MenuController::class, 'deleteFood']);

