<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getCategoryProduct(Request $request, Category $category)
    {
        $products = $category->products()->get();

        $categoryProduct = collect()->merge([
            "category" => $category,
            "products" => $products
        ]);

        return SuccessResponse::make(CategoryProductResource::make($categoryProduct), 'Get products in category');
    }
}
