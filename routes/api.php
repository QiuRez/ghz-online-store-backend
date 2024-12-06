<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('main/info', [MainController::class, 'getMainInfo']);
Route::get('category/products/{category:slug}', [CategoryController::class, 'getCategoryProduct']);

Route::post('user/sendCode', [UserController::class, 'sendCode']);
Route::post('user/auth', [UserController::class, 'auth']);
