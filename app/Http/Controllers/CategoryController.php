<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryProductResource;
use App\Http\Resources\ResponseBase\ErrorResponse;
use App\Http\Resources\ResponseBase\SuccessResponse;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class CategoryController extends Controller
{
    public function getCategoryProduct(Request $request, Category $category)
    {
        if ($category->status == false) {
            return ErrorResponse::make('Category status false', SymfonyResponse::HTTP_NOT_FOUND);
        }

        $products = $category->products()->get();

        $categoryProduct = collect()->merge([
            "category" => $category,
            "products" => $products
        ]);

        return SuccessResponse::make(CategoryProductResource::make($categoryProduct), 'Get products in category');
    }
}
