<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('main/info', [MainController::class, 'getMainInfo']);
Route::get('category/products/{category:slug}', [CategoryController::class, 'getCategoryProduct']);