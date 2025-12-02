<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/api/login', [LoginController::class, 'login']);
//Menu Route by Omar
Route::get('/api/menu', [MenuController::class, 'menu']);
