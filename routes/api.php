<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('main/info', [MainController::class, 'getMainInfo']);
Route::get('category/products/{category:slug}', [CategoryController::class, 'getCategoryProduct']);
Route::get('company/products/{company:slug}', [CompanyController::class, 'getCompanyProducts']);
Route::get('products/all', [ProductController::class, 'getProducts']);
Route::get('products/discount/all', [ProductController::class, 'getDiscountsProduct']);
Route::get('products/first/{slug}', [ProductController::class, 'getOneProduct']);

Route::get('search/{q}', [MainController::class, 'search']);

Route::middleware(['auth:sanctum'])->group(function() {
  Route::post('/user/cart/add', [CartController::class, 'addProduct']);
  Route::post('/user/cart/remove', [CartController::class, 'removeProduct']);
  Route::post('/user/cart/removeAllProduct', [CartController::class, 'removeAllProduct']);
  Route::get('/user/cart/get', [CartController::class, 'getCart']);
});

Route::post('user/sendCode', [UserController::class, 'sendCode']);
Route::post('user/auth', [UserController::class, 'auth']);
