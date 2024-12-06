<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('main/info', [MainController::class, 'getMainInfo']);
Route::get('category/products/{category:slug}', [CategoryController::class, 'getCategoryProduct']);

Route::post('user/auth', [UserController::class, 'auth']);

Route::post('email/verify', [UserController::class, 'registerVerify'])
  ->name('verification.verify');

Route::post('email/verify-resent', [UserController::class, 'registerVerifyReSent'])
  ->name('verification.verify.resent');


Route::post('test', [UserController::class, 'test']);