<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/login', [LoginController::class, 'login']);
Route::get('/api/menu', [MenuController::class, 'menu']);
Route::post('/api/categories', [MenuController::class, 'addCategory']);
Route::post('/api/foods', [MenuController::class, 'addfood']);
Route::put('/api/categorie/{id}', [MenuController::class, 'updateCategory']);
Route::put('/api/food/{id}', [MenuController::class, 'updateFood']);
Route::delete('/api/categorie/{id}', [MenuController::class, 'deleteCategory']);
Route::delete('/api/food/{id}', [MenuController::class, 'deleteFood']);
Route::post('/api/message', [ContactController::class, 'submitMessage']);
