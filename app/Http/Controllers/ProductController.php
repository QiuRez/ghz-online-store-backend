<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductOneRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseBase\ErrorResponse;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProducts(Request $request)
    {
        return SuccessResponse::make(ProductResource::make(Product::all()), 'Get all products');
    }

    public function getDiscountsProduct(Request $request)
    {
        return SuccessResponse::make(ProductResource::make(Product::has('discount')->get()), 'Get all discount products');
    }

    public function getOneProduct(Request $request, string $slug)
    {
        if ($product = Product::with('company')->firstWhere('slug', '=', $slug)) {
            return SuccessResponse::make(ProductResource::make($product), 'Get one product');
        } else {
            return ErrorResponse::make('Not found');
        }
    }
}
